import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import { settingsSchema } from '@/lib/validators';

export async function PATCH(request: Request) {
  const { userId } = auth();
  if (!userId) return NextResponse.json({ error: 'Unauthenticated' }, { status: 401 });

  const body = await request.json();
  const parsed = settingsSchema.safeParse(body);
  if (!parsed.success) return NextResponse.json({ error: 'Invalid input' }, { status: 400 });

  const user = await prisma.user.updateMany({
    where: { clerkId: userId },
    data: { name: parsed.data.name, email: parsed.data.email },
  });

  return NextResponse.json({ ok: true, updated: user.count });
}
