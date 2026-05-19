import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import { conversationSchema } from '@/lib/validators';
import { askClaude } from '@/lib/anthropic';
import { checkRateLimit } from '@/lib/rate-limit';

export async function POST(request: Request) {
  const { userId } = auth();
  if (!userId) return NextResponse.json({ error: 'Unauthenticated' }, { status: 401 });

  const body = await request.json();
  const parsed = conversationSchema.safeParse(body);
  if (!parsed.success) return NextResponse.json({ error: 'Invalid input' }, { status: 400 });

  const user = await prisma.user.findUnique({ where: { clerkId: userId } });
  if (!user) return NextResponse.json({ error: 'User not found' }, { status: 404 });

  const document = await prisma.document.findUnique({ where: { id: parsed.data.documentId } });
  if (!document || document.userId !== user.id) return NextResponse.json({ error: 'Document not found' }, { status: 404 });

  const limit = await checkRateLimit(user.id, user.plan);
  if (!limit.allowed) {
    return NextResponse.json({ error: 'Rate limit exceeded', limit }, { status: 429 });
  }

  const answer = await askClaude(parsed.data.question, document.extractedText);
  let conversation = await prisma.conversation.findFirst({
    where: { documentId: document.id, userId: user.id },
  });

  if (!conversation) {
    conversation = await prisma.conversation.create({
      data: {
        documentId: document.id,
        userId: user.id,
      },
    });
  }

  await prisma.message.createMany({
    data: [
      { conversationId: conversation.id, role: 'user', content: parsed.data.question },
      { conversationId: conversation.id, role: 'assistant', content: answer },
    ],
  });

  return NextResponse.json({ answer });
}
