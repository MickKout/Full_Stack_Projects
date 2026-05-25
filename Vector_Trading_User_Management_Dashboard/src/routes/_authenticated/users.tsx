import { createFileRoute } from "@tanstack/react-router";
import { queryOptions, useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { useServerFn } from "@tanstack/react-start";
import { listUsers, setUserRole, updateUserStatus, getCurrentUserContext } from "@/lib/users.functions";
import { useMemo, useState } from "react";
import { Search } from "lucide-react";
import { Input } from "@/components/ui/input";
import {
  Select, SelectContent, SelectItem, SelectTrigger, SelectValue,
} from "@/components/ui/select";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { toast } from "sonner";
import { format } from "date-fns";

export const Route = createFileRoute("/_authenticated/users")({
  component: UsersPage,
});

const ROLES = ["admin", "trader", "viewer"] as const;
const STATUSES = ["active", "pending", "suspended"] as const;

function UsersPage() {
  const qc = useQueryClient();
  const fetchUsers = useServerFn(listUsers);
  const fetchMe = useServerFn(getCurrentUserContext);
  const setRole = useServerFn(setUserRole);
  const setStatus = useServerFn(updateUserStatus);

  const usersQ = useQuery(queryOptions({ queryKey: ["users"], queryFn: () => fetchUsers() }));
  const meQ = useQuery(queryOptions({ queryKey: ["me"], queryFn: () => fetchMe() }));
  const isAdmin = !!meQ.data?.isAdmin;

  const [search, setSearch] = useState("");
  const [roleFilter, setRoleFilter] = useState<string>("all");
  const [statusFilter, setStatusFilter] = useState<string>("all");

  const roleMutation = useMutation({
    mutationFn: async (v: { userId: string; role: typeof ROLES[number] }) =>
      setRole({ data: v }),
    onSuccess: () => {
      toast.success("Role updated");
      qc.invalidateQueries({ queryKey: ["users"] });
    },
    onError: (e) => toast.error(e instanceof Error ? e.message : "Failed"),
  });

  const statusMutation = useMutation({
    mutationFn: async (v: { userId: string; status: typeof STATUSES[number] }) =>
      setStatus({ data: v }),
    onSuccess: () => {
      toast.success("Status updated");
      qc.invalidateQueries({ queryKey: ["users"] });
    },
    onError: (e) => toast.error(e instanceof Error ? e.message : "Failed"),
  });

  const rows = useMemo(() => {
    const profiles = usersQ.data?.profiles ?? [];
    const roles = usersQ.data?.roles ?? [];
    return profiles
      .map((p) => ({
        ...p,
        role: (roles.find((r) => r.user_id === p.id)?.role ?? "viewer") as typeof ROLES[number],
      }))
      .filter((p) => {
        if (roleFilter !== "all" && p.role !== roleFilter) return false;
        if (statusFilter !== "all" && p.status !== statusFilter) return false;
        if (search) {
          const q = search.toLowerCase();
          return (
            p.email.toLowerCase().includes(q) ||
            (p.full_name ?? "").toLowerCase().includes(q) ||
            (p.desk ?? "").toLowerCase().includes(q)
          );
        }
        return true;
      });
  }, [usersQ.data, search, roleFilter, statusFilter]);

  return (
    <div className="mx-auto max-w-6xl space-y-8">
      <div className="flex items-end justify-between">
        <div>
          <p className="font-mono text-[11px] uppercase tracking-widest text-muted-foreground">
            User management
          </p>
          <h1 className="mt-2 text-3xl font-semibold tracking-tight">Members</h1>
          <p className="mt-2 text-sm text-muted-foreground">
            {isAdmin
              ? "Manage trader access, roles, and account status."
              : "View workspace members. Only admins can change roles."}
          </p>
        </div>
        <div className="font-mono text-xs text-muted-foreground tabular-nums">
          {rows.length} {rows.length === 1 ? "member" : "members"}
        </div>
      </div>

      <div className="flex flex-wrap items-center gap-3">
        <div className="relative flex-1 min-w-[200px]">
          <Search className="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
          <Input
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            placeholder="Search by name, email, or desk…"
            className="h-10 bg-card pl-9"
          />
        </div>
        <Select value={roleFilter} onValueChange={setRoleFilter}>
          <SelectTrigger className="h-10 w-[140px] bg-card"><SelectValue /></SelectTrigger>
          <SelectContent>
            <SelectItem value="all">All roles</SelectItem>
            {ROLES.map((r) => <SelectItem key={r} value={r}>{r}</SelectItem>)}
          </SelectContent>
        </Select>
        <Select value={statusFilter} onValueChange={setStatusFilter}>
          <SelectTrigger className="h-10 w-[140px] bg-card"><SelectValue /></SelectTrigger>
          <SelectContent>
            <SelectItem value="all">All status</SelectItem>
            {STATUSES.map((s) => <SelectItem key={s} value={s}>{s}</SelectItem>)}
          </SelectContent>
        </Select>
      </div>

      <div className="overflow-hidden rounded-xl border border-border bg-card">
        <div className="grid grid-cols-[1.6fr_1fr_1fr_1fr_1fr] gap-4 border-b border-border bg-muted/30 px-5 py-3 font-mono text-[10px] uppercase tracking-widest text-muted-foreground">
          <div>Member</div>
          <div>Desk</div>
          <div>Role</div>
          <div>Status</div>
          <div className="text-right">Joined</div>
        </div>
        <ul className="divide-y divide-border">
          {usersQ.isLoading && (
            <li className="px-5 py-10 text-center text-sm text-muted-foreground">Loading…</li>
          )}
          {!usersQ.isLoading && rows.length === 0 && (
            <li className="px-5 py-10 text-center text-sm text-muted-foreground">No members match.</li>
          )}
          {rows.map((u) => {
            const initial = (u.full_name || u.email).slice(0, 1).toUpperCase();
            const isSelf = meQ.data?.userId === u.id;
            return (
              <li key={u.id} className="grid grid-cols-[1.6fr_1fr_1fr_1fr_1fr] items-center gap-4 px-5 py-4">
                <div className="flex min-w-0 items-center gap-3">
                  <Avatar className="h-8 w-8">
                    <AvatarFallback className="bg-accent text-xs">{initial}</AvatarFallback>
                  </Avatar>
                  <div className="min-w-0">
                    <p className="truncate text-sm font-medium">
                      {u.full_name ?? u.email}
                      {isSelf && <span className="ml-2 rounded border border-border px-1.5 py-0.5 font-mono text-[9px] uppercase text-muted-foreground">you</span>}
                    </p>
                    <p className="truncate font-mono text-[11px] text-muted-foreground">{u.email}</p>
                  </div>
                </div>
                <div className="font-mono text-xs text-muted-foreground">{u.desk ?? "—"}</div>
                <div>
                  <Select
                    value={u.role}
                    disabled={!isAdmin || isSelf || roleMutation.isPending}
                    onValueChange={(v) => roleMutation.mutate({ userId: u.id, role: v as typeof ROLES[number] })}
                  >
                    <SelectTrigger className="h-8 w-[110px] bg-background"><SelectValue /></SelectTrigger>
                    <SelectContent>
                      {ROLES.map((r) => <SelectItem key={r} value={r}>{r}</SelectItem>)}
                    </SelectContent>
                  </Select>
                </div>
                <div>
                  <Select
                    value={u.status}
                    disabled={!isAdmin || statusMutation.isPending}
                    onValueChange={(v) => statusMutation.mutate({ userId: u.id, status: v as typeof STATUSES[number] })}
                  >
                    <SelectTrigger className="h-8 w-[120px] bg-background"><SelectValue /></SelectTrigger>
                    <SelectContent>
                      {STATUSES.map((s) => <SelectItem key={s} value={s}>{s}</SelectItem>)}
                    </SelectContent>
                  </Select>
                </div>
                <div className="text-right font-mono text-xs text-muted-foreground">
                  {format(new Date(u.created_at), "MMM d, yyyy")}
                </div>
              </li>
            );
          })}
        </ul>
      </div>
    </div>
  );
}
