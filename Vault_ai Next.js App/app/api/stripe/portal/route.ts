import { NextResponse } from 'next/server';
import { auth } from '@clerk/nextjs';
import { stripe } from '@/lib/stripe';
import { prisma } from '@/lib/prisma';

export async function GET(request: Request) {
  const { userId } = auth();
  if (!userId) return NextResponse.redirect(new URL('/sign-in', request.url));

  const user = await prisma.user.findUnique({ where: { clerkId: userId } });
  if (!user?.stripeCustomerId) {
    return NextResponse.redirect(new URL('/dashboard/billing', request.url));
  }

  const session = await stripe.billingPortal.sessions.create({
    customer: user.stripeCustomerId,
    return_url: `${new URL(request.url).origin}/dashboard/billing`,
  });

  return NextResponse.redirect(session.url ?? '/dashboard/billing');
}
