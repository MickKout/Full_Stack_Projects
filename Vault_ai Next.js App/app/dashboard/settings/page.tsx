import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import SettingsForm from '@/components/dashboard/settings-form';

export default async function SettingsPage() {
  const { userId } = auth();
  const user = await prisma.user.findUnique({
    where: { clerkId: userId ?? undefined },
  });

  if (!user) {
    return <div className="rounded-[2rem] border border-slate-800 bg-slate-900/90 p-8 text-slate-300">User not found.</div>;
  }

  return (
    <div className="space-y-10">
      <section className="rounded-[2rem] border border-slate-800 bg-slate-900/90 p-8">
        <h1 className="text-2xl font-semibold text-white">Settings</h1>
        <p className="mt-2 text-slate-400">Update your display name and email, or delete your account.</p>
      </section>
      <SettingsForm defaultName={user.name ?? ''} defaultEmail={user.email} />
    </div>
  );
}
