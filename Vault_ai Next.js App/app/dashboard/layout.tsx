import Link from 'next/link';
import { auth } from '@clerk/nextjs';

export default async function DashboardLayout({ children }: { children: React.ReactNode }) {
  const { userId } = auth();

  return (
    <div className="min-h-screen bg-slate-950 text-slate-100">
      <div className="mx-auto flex min-h-screen max-w-7xl gap-8 px-6 py-8 sm:px-10 lg:px-16">
        <aside className="hidden w-72 shrink-0 rounded-[2rem] border border-slate-800 bg-slate-900/90 p-6 lg:block">
          <div className="mb-8 space-y-2">
            <p className="text-xs uppercase tracking-[0.4em] text-cyan-300">Dashboard</p>
            <h2 className="text-2xl font-semibold">Vault Workspace</h2>
          </div>
          <nav className="space-y-2 text-sm text-slate-300">
            <Link className="block rounded-2xl px-4 py-3 hover:bg-slate-800" href="/dashboard/documents">Documents</Link>
            <Link className="block rounded-2xl px-4 py-3 hover:bg-slate-800" href="/dashboard/billing">Billing</Link>
            <Link className="block rounded-2xl px-4 py-3 hover:bg-slate-800" href="/dashboard/settings">Settings</Link>
          </nav>
        </aside>

        <div className="flex-1 space-y-8">
          <header className="flex flex-col gap-4 rounded-[2rem] border border-slate-800 bg-slate-900/90 p-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
              <p className="text-sm uppercase tracking-[0.35em] text-cyan-300">Welcome back</p>
              <h1 className="text-2xl font-semibold">Your VaultAI workspace</h1>
            </div>
            <div className="rounded-3xl bg-slate-950/80 px-4 py-3 text-sm text-slate-300">
              User ID: {userId ?? 'anonymous'}
            </div>
          </header>
          {children}
        </div>
      </div>
    </div>
  );
}
