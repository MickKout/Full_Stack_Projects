import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import { Card, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

export default async function BillingPage() {
  const { userId } = auth();
  const user = await prisma.user.findUnique({
    where: { clerkId: userId ?? undefined },
    include: { subscriptions: true },
  });

  const subscription = user?.subscriptions?.[0];
  const plan = user?.plan ?? 'free';
  const nextBill = subscription ? new Date(subscription.currentPeriodEnd).toLocaleDateString() : 'N/A';

  return (
    <div className="space-y-8">
      <section className="grid gap-6 lg:grid-cols-2">
        <Card className="bg-slate-900/90 border-slate-800">
          <CardHeader>
            <CardTitle>Plan details</CardTitle>
          </CardHeader>
          <CardDescription>Current plan: <strong>{plan.toUpperCase()}</strong></CardDescription>
          <div className="mt-4 space-y-3 text-sm text-slate-300">
            <p>Next billing date: {nextBill}</p>
            <p>Usage limits vary by plan and are enforced automatically.</p>
          </div>
        </Card>
        <Card className="bg-slate-900/90 border-slate-800">
          <CardHeader>
            <CardTitle>Manage subscription</CardTitle>
          </CardHeader>
          <CardDescription>Use the Stripe portal to update payment methods or cancel at any time.</CardDescription>
          <div className="mt-6 flex flex-col gap-3">
            <a href="/api/stripe/portal" className="inline-flex w-full items-center justify-center rounded-full bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
              Open customer portal
            </a>
            <a href="/api/stripe/checkout?priceId=pro" className="inline-flex w-full items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-100">
              Upgrade to Pro
            </a>
            <a href="/api/stripe/checkout?priceId=team" className="inline-flex w-full items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-100">
              Upgrade to Team
            </a>
          </div>
        </Card>
      </section>

      <section className="rounded-[2rem] border border-slate-800 bg-slate-900/90 p-6">
        <h2 className="text-xl font-semibold text-white">Billing FAQ</h2>
        <p className="mt-3 text-sm text-slate-400">Stripe handles secure payment processing. You can upgrade, downgrade, or cancel anytime.</p>
      </section>
    </div>
  );
}
