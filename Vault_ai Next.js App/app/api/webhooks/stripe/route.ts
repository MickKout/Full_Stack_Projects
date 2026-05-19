import { NextResponse } from 'next/server';
import { Stripe } from 'stripe';
import { stripe } from '@/lib/stripe';
import { env } from '@/lib/env';
import { prisma } from '@/lib/prisma';
import { subscriptionConfirmation, paymentFailedEmail } from '@/lib/email';

export const runtime = 'node';

export async function POST(request: Request) {
  const signature = request.headers.get('stripe-signature') ?? '';
  const body = await request.text();
  let event: Stripe.Event;

  try {
    event = stripe.webhooks.constructEvent(body, signature, env.STRIPE_WEBHOOK_SECRET);
  } catch (error) {
    return NextResponse.json({ error: 'Webhook signature verification failed' }, { status: 400 });
  }

  const session = event.data.object as Stripe.Checkout.Session | Stripe.Subscription | Stripe.Invoice;
  switch (event.type) {
    case 'checkout.session.completed': {
      const subscriptionId = (session as Stripe.Checkout.Session).subscription as string;
      const customerId = (session as Stripe.Checkout.Session).customer as string;
      const priceId = (session as Stripe.Checkout.Session).display_items?.[0]?.price?.id || event.data.object['line_items']?.data?.[0]?.price?.id;
      const stripeSubscription = await stripe.subscriptions.retrieve(subscriptionId);
      const user = await prisma.user.findFirst({ where: { stripeCustomerId: customerId } });
      if (user) {
        await prisma.subscription.upsert({
          where: { stripeSubscriptionId: subscriptionId },
          update: {
            status: stripeSubscription.status as any,
            priceId: stripeSubscription.items.data[0]?.price.id ?? '',
            currentPeriodEnd: new Date(stripeSubscription.current_period_end * 1000),
            userId: user.id,
          },
          create: {
            userId: user.id,
            stripeSubscriptionId: subscriptionId,
            status: stripeSubscription.status as any,
            priceId: stripeSubscription.items.data[0]?.price.id ?? '',
            currentPeriodEnd: new Date(stripeSubscription.current_period_end * 1000),
          },
        });
        await subscriptionConfirmation(user.email, stripeSubscription.items.data[0]?.price.nickname ?? 'Pro');
      }
      break;
    }
    case 'customer.subscription.updated':
    case 'customer.subscription.deleted': {
      const subscription = event.data.object as Stripe.Subscription;
      await prisma.subscription.updateMany({
        where: { stripeSubscriptionId: subscription.id },
        data: {
          status: subscription.status as any,
          currentPeriodEnd: new Date(subscription.current_period_end * 1000),
        },
      });
      break;
    }
    case 'invoice.payment_failed': {
      const invoice = event.data.object as Stripe.Invoice;
      const customerId = invoice.customer as string;
      const user = await prisma.user.findFirst({ where: { stripeCustomerId: customerId } });
      if (user) {
        await paymentFailedEmail(user.email);
      }
      break;
    }
    default:
      break;
  }

  return NextResponse.json({ received: true });
}
