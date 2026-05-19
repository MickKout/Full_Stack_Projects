import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';

export async function POST() {
  const { userId } = auth();
  if (!userId) return NextResponse.json({ error: 'Unauthenticated' }, { status: 401 });

  const user = await prisma.user.findUnique({ where: { clerkId: userId } });
  if (!user) return NextResponse.json({ error: 'User not found' }, { status: 404 });

  await prisma.message.deleteMany({ where: { conversation: { userId: user.id } } });
  await prisma.conversation.deleteMany({ where: { userId: user.id } });
  await prisma.document.deleteMany({ where: { userId: user.id } });
  await prisma.subscription.deleteMany({ where: { userId: user.id } });
  await prisma.user.delete({ where: { id: user.id } });

  return NextResponse.json({ ok: true });
}
