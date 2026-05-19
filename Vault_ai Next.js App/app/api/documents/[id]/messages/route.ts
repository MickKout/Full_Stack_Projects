import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';

interface Params {
  params: { id: string };
}

export async function GET(_request: Request, { params }: Params) {
  const { userId } = auth();
  if (!userId) return NextResponse.json({ error: 'Unauthenticated' }, { status: 401 });

  const document = await prisma.document.findFirst({
    where: { id: params.id, user: { clerkId: userId } },
  });
  if (!document) return NextResponse.json({ error: 'Not found' }, { status: 404 });

  const conversation = await prisma.conversation.findFirst({
    where: { documentId: document.id, user: { clerkId: userId } },
    include: { messages: true },
  });

  return NextResponse.json({ messages: conversation?.messages ?? [] });
}
