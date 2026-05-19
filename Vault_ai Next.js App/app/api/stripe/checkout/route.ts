import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { stripe } from '@/lib/stripe';
import { env } from '@/lib/env';
import { prisma } from '@/lib/prisma';

const priceMap = {
  pro: env.STRIPE_PRICE_PRO,
  team: env.STRIPE_PRICE_TEAM,
};

export async function GET(request: Request) {
  const { userId } = auth();
  if (!userId) return NextResponse.redirect(new URL('/sign-in', request.url));

  const url = new URL(request.url);
  const priceId = url.searchParams.get('priceId');
  if (!priceId || !priceMap[priceId as 'pro' | 'team']) {
    return NextResponse.json({ error: 'Invalid price id' }, { status: 400 });
  }

  const user = await prisma.user.findUnique({ where: { clerkId: userId } });
  if (!user) return NextResponse.json({ error: 'User not found' }, { status: 404 });

  let customerId = user.stripeCustomerId;
  if (!customerId) {
    const stripeCustomer = await stripe.customers.create({ email: user.email, name: user.name ?? undefined });
    customerId = stripeCustomer.id;
    await prisma.user.update({ where: { id: user.id }, data: { stripeCustomerId: customerId } });
  }

  const session = await stripe.checkout.sessions.create({
    mode: 'subscription',
    customer: customerId,
    line_items: [{ price: priceMap[priceId as 'pro' | 'team'], quantity: 1 }],
    success_url: `${url.origin}/dashboard/billing`,
    cancel_url: `${url.origin}/dashboard/billing`,
  });

  return NextResponse.redirect(session.url ?? '/dashboard/billing');
}
