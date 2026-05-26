import { createFileRoute } from "@tanstack/react-router";
import { queryOptions, useQuery } from "@tanstack/react-query";
import { useServerFn } from "@tanstack/react-start";
import { listUsers, getCurrentUserContext } from "@/lib/users.functions";
import { Users, ShieldCheck, Activity, Wallet } from "lucide-react";

export const Route = createFileRoute("/_authenticated/dashboard")({
  component: DashboardPage,
});

function DashboardPage() {
  const fetchUsers = useServerFn(listUsers);
  const fetchMe = useServerFn(getCurrentUserContext);
  const usersQ = useQuery(queryOptions({ queryKey: ["users"], queryFn: () => fetchUsers() }));
  const meQ = useQuery(queryOptions({ queryKey: ["me"], queryFn: () => fetchMe() }));

  const profiles = usersQ.data?.profiles ?? [];
  const roles = usersQ.data?.roles ?? [];

  const stats = [
    { label: "Total users", value: profiles.length, icon: Users, hint: "across desks" },
    { label: "Active", value: profiles.filter((p) => p.status === "active").length, icon: Activity, hint: "currently trading" },
    { label: "Admins", value: roles.filter((r) => r.role === "admin").length, icon: ShieldCheck, hint: "workspace owners" },
    { label: "Desks", value: new Set(profiles.map((p) => p.desk).filter(Boolean)).size, icon: Wallet, hint: "distinct teams" },
  ];

  return (
    <div className="mx-auto max-w-6xl space-y-10">
      <div>
        <p className="font-mono text-[11px] uppercase tracking-widest text-muted-foreground">Overview</p>
        <h1 className="mt-2 text-3xl font-semibold tracking-tight">
          Welcome back{meQ.data?.profile?.full_name ? `, ${meQ.data.profile.full_name.split(" ")[0]}` : ""}.
        </h1>
        <p className="mt-2 text-sm text-muted-foreground">
          Your trading workspace at a glance.
        </p>
      </div>

      <div className="grid grid-cols-1 gap-px overflow-hidden rounded-xl border border-border bg-border sm:grid-cols-2 lg:grid-cols-4">
        {stats.map((s) => (
          <div key={s.label} className="bg-card p-5">
            <div className="flex items-center justify-between">
              <p className="font-mono text-[11px] uppercase tracking-widest text-muted-foreground">
                {s.label}
              </p>
              <s.icon className="h-4 w-4 text-muted-foreground" />
            </div>
            <p className="mt-3 text-3xl font-semibold tracking-tight tabular-nums">
              {usersQ.isLoading ? "—" : s.value}
            </p>
            <p className="mt-1 text-xs text-muted-foreground">{s.hint}</p>
          </div>
        ))}
      </div>

      <div className="rounded-xl border border-border bg-card">
        <div className="flex items-center justify-between border-b border-border px-5 py-4">
          <div>
            <h2 className="text-sm font-semibold">Recent signups</h2>
            <p className="text-xs text-muted-foreground">Last members added to your workspace</p>
          </div>
        </div>
        <ul className="divide-y divide-border">
          {profiles.slice(0, 5).map((p) => {
            const r = roles.find((x) => x.user_id === p.id)?.role ?? "viewer";
            return (
              <li key={p.id} className="flex items-center justify-between px-5 py-3.5">
                <div className="min-w-0">
                  <p className="truncate text-sm font-medium">{p.full_name ?? p.email}</p>
                  <p className="truncate font-mono text-[11px] text-muted-foreground">{p.email}</p>
                </div>
                <div className="flex items-center gap-3">
                  <span className="font-mono text-[10px] uppercase tracking-widest text-muted-foreground">
                    {r}
                  </span>
                  <StatusDot status={p.status} />
                </div>
              </li>
            );
          })}
          {profiles.length === 0 && !usersQ.isLoading && (
            <li className="px-5 py-10 text-center text-sm text-muted-foreground">No users yet.</li>
          )}
        </ul>
      </div>
    </div>
  );
}

function StatusDot({ status }: { status: string }) {
  const color =
    status === "active" ? "bg-success" : status === "suspended" ? "bg-destructive" : "bg-warning";
  return (
    <span className="inline-flex items-center gap-1.5">
      <span className={`h-1.5 w-1.5 rounded-full ${color}`} />
      <span className="font-mono text-[10px] uppercase tracking-widest text-muted-foreground">{status}</span>
    </span>
  );
}
