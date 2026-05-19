import { NextResponse } from 'next/server';
import { env } from '@/lib/env';
import { prisma } from '@/lib/prisma';

export async function POST(request: Request) {
  const signature = request.headers.get('clerk-signature') ?? '';
  const body = await request.text();

  const expectedSignature = env.CLERK_WEBHOOK_SECRET;
  if (!signature || signature !== expectedSignature) {
    return NextResponse.json({ error: 'Invalid webhook signature' }, { status: 400 });
  }

  const payload = JSON.parse(body);
  if (payload.type === 'user.created' && payload.data?.id) {
    const user = payload.data;
    await prisma.user.upsert({
      where: { clerkId: user.id },
      update: {
        email: user.email_addresses?.[0]?.email_address ?? user.email,
        name: user.first_name ? `${user.first_name} ${user.last_name ?? ''}`.trim() : user.full_name ?? undefined,
      },
      create: {
        clerkId: user.id,
        email: user.email_addresses?.[0]?.email_address ?? user.email,
        name: user.first_name ? `${user.first_name} ${user.last_name ?? ''}`.trim() : user.full_name ?? undefined,
      },
    });
  }

  return NextResponse.json({ received: true });
}
