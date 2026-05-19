import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import { env } from '@/lib/env';

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

  const uploadEndpoint = env.NEXT_PUBLIC_UPLOADTHING_URL;
  const uploadForm = new FormData();
  uploadForm.append('file', file as Blob, file.name);

  const uploadRes = await fetch(uploadEndpoint, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${env.UPLOADTHING_SECRET}`,
    },
    body: uploadForm,
  });

  const uploadData = await uploadRes.json().catch(() => null);
  const url = uploadData?.url ?? `${uploadEndpoint}/${encodeURIComponent(file.name)}`;

  const extractedText = `Extracted text from ${name}. Replace this placeholder with a document parser for full extraction.`;

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
