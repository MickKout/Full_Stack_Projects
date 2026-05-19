import Link from 'next/link';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import { Button } from '@/components/ui/button';
import { Card, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

export default async function DashboardPage() {
  const { userId } = auth();
  const user = await prisma.user.findUnique({
    where: { clerkId: userId ?? undefined },
    include: { documents: true, subscriptions: true },
  });

  const documents = user?.documents ?? [];
  const subscription = user?.subscriptions?.[0];
  const plan = user?.plan ?? 'free';
  const limit = plan === 'pro' ? 50 : plan === 'team' ? 9999 : 3;

  return (
    <div className="space-y-10">
      <section className="grid gap-6 lg:grid-cols-3">
        <Card className="bg-slate-900/90 border-slate-800">
          <CardHeader>
            <CardTitle>Plan</CardTitle>
          </CardHeader>
          <CardDescription>Your current plan is <strong>{plan.toUpperCase()}</strong>.</CardDescription>
        </Card>
        <Card className="bg-slate-900/90 border-slate-800">
          <CardHeader>
            <CardTitle>Documents</CardTitle>
          </CardHeader>
          <CardDescription>{documents.length} uploaded / {limit} allowed</CardDescription>
        </Card>
        <Card className="bg-slate-900/90 border-slate-800">
          <CardHeader>
            <CardTitle>Billing</CardTitle>
          </CardHeader>
          <CardDescription>{subscription ? `Next bill: ${new Date(subscription.currentPeriodEnd).toLocaleDateString()}` : 'No active subscription'}</CardDescription>
        </Card>
      </section>

      <section className="grid gap-6">
        <div className="flex flex-col gap-4 rounded-[2rem] border border-slate-800 bg-slate-900/90 p-6">
          <div className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
              <h2 className="text-xl font-semibold text-white">Your documents</h2>
              <p className="text-sm text-slate-400">Upload new documents or continue analyzing existing files.</p>
            </div>
            <Link href="/dashboard/documents" className="inline-flex">
              <Button>Manage documents</Button>
            </Link>
          </div>

          <div className="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            {documents.slice(0, 3).map((document) => (
              <div key={document.id} className="rounded-3xl border border-slate-800 bg-slate-950/90 p-4">
                <h3 className="text-lg font-semibold text-white">{document.name}</h3>
                <p className="mt-2 text-sm text-slate-400">Uploaded on {new Date(document.createdAt).toLocaleDateString()}</p>
                <Link href={`/dashboard/documents/${document.id}`} className="mt-4 inline-flex text-sm text-cyan-300 hover:underline">Ask questions →</Link>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
