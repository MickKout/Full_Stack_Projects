import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import { env } from '@/lib/env';
import pdf from 'pdf-parse';

export async function POST(request: Request) {
  const { userId } = auth();
  if (!userId) {
    return NextResponse.json({ error: 'Unauthenticated' }, { status: 401 });
  }

  const formData = await request.formData();
  const name = formData.get('name');
  const file = formData.get('file') as File | null;

  if (!name || typeof name !== 'string' || !file) {
    return NextResponse.json({ error: 'Invalid upload data' }, { status: 400 });
  }

  // Read file buffer
  const arrayBuffer = await (file as Blob).arrayBuffer();
  const buffer = Buffer.from(arrayBuffer);

  // If PDF, extract text using pdf-parse
  let extractedText = '';
  try {
    if (file.type === 'application/pdf' || name.toLowerCase().endsWith('.pdf')) {
      const parsed = await pdf(buffer as Buffer);
      extractedText = parsed.text ?? '';
    } else {
      // For non-PDFs, keep placeholder — future: add docx parsing
      extractedText = `Uploaded file ${name} — text extraction not implemented for this type.`;
    }
  } catch (err) {
    extractedText = `Could not extract text from ${name}.`;
  }

  // Upload to Uploadthing (simple POST proxy). Replace with Uploadthing SDK if available.
  const uploadEndpoint = env.NEXT_PUBLIC_UPLOADTHING_URL;
  const uploadForm = new FormData();
  uploadForm.append('file', file as Blob, (file as File).name ?? name);

  const uploadRes = await fetch(uploadEndpoint, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${env.UPLOADTHING_SECRET}`,
    },
    body: uploadForm,
  }).catch(() => null);

  const uploadData = uploadRes ? await uploadRes.json().catch(() => null) : null;
  const url = uploadData?.url ?? `${uploadEndpoint}/${encodeURIComponent((file as File).name ?? name)}`;

  const user = await prisma.user.findUnique({ where: { clerkId: userId } });
  if (!user) return NextResponse.json({ error: 'User not found' }, { status: 404 });

  await prisma.document.create({
    data: {
      userId: user.id,
      name,
      url,
      extractedText,
    },
  });

  return NextResponse.json({ ok: true });
}
