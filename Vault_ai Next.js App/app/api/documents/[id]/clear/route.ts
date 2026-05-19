import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';

interface Params {
  params: { id: string };
}

export async function POST(_request: Request, { params }: Params) {
  const { userId } = auth();
  if (!userId) return NextResponse.json({ error: 'Unauthenticated' }, { status: 401 });

  const document = await prisma.document.findFirst({
    where: { id: params.id, user: { clerkId: userId } },
    include: { conversations: true },
  });
  if (!document) return NextResponse.json({ error: 'Not found' }, { status: 404 });

  const conversationIds = document.conversations.map((conversation) => conversation.id);
  await prisma.message.deleteMany({ where: { conversationId: { in: conversationIds } } });
  await prisma.conversation.deleteMany({ where: { id: { in: conversationIds } } });

  return NextResponse.json({ ok: true });
}
