import { createFileRoute, Outlet, redirect, Link, useRouter, useRouterState } from "@tanstack/react-router";
import { queryOptions, useQuery, useQueryClient } from "@tanstack/react-query";
import { useServerFn } from "@tanstack/react-start";
import { supabase } from "@/integrations/supabase/client";
import { getCurrentUserContext } from "@/lib/users.functions";
import { LayoutDashboard, Users, LogOut, Settings, TrendingUp } from "lucide-react";
import { Avatar, AvatarFallback } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";

export const Route = createFileRoute("/_authenticated")({
  beforeLoad: async ({ location }) => {
    const { data, error } = await supabase.auth.getUser();
    if (error || !data.user) {
      throw redirect({
        to: "/login",
        search: { redirect: location.href },
      });
    }
  },
  component: AuthenticatedLayout,
});

function AuthenticatedLayout() {
  const fetchCtx = useServerFn(getCurrentUserContext);
  const ctxQuery = useQuery(
    queryOptions({
      queryKey: ["me"],
      queryFn: () => fetchCtx(),
    }),
  );

  const router = useRouter();
  const queryClient = useQueryClient();
  const pathname = useRouterState({ select: (s) => s.location.pathname });

  const signOut = async () => {
    await supabase.auth.signOut();
    queryClient.clear();
    router.navigate({ to: "/login" });
  };

  const navItems = [
    { to: "/dashboard", label: "Overview", icon: LayoutDashboard },
    { to: "/users", label: "Users", icon: Users },
    { to: "/settings", label: "Settings", icon: Settings },
  ] as const;

  const me = ctxQuery.data;
  const initial = (me?.profile?.full_name || me?.profile?.email || "?").slice(0, 1).toUpperCase();

  return (
    <div className="flex min-h-screen w-full text-foreground">
      <aside className="hidden md:flex w-60 shrink-0 flex-col border-r border-sidebar-border/50 bg-sidebar/80 backdrop-blur-xl">
        <div className="flex h-14 items-center gap-2 border-b border-sidebar-border px-5">
          <div className="h-5 w-5 rotate-45 bg-foreground" />
          <span className="font-mono text-sm tracking-tight">VECTOR</span>
        </div>

        <nav className="flex-1 p-3">
          <p className="px-2 py-2 font-mono text-[10px] uppercase tracking-widest text-muted-foreground">
            Workspace
          </p>
          {navItems.map((item) => {
            const active = pathname === item.to || pathname.startsWith(item.to + "/");
            return (
              <Link
                key={item.to}
                to={item.to}
                className={
                  "group mt-1 flex items-center gap-3 rounded-md px-2.5 py-2 text-sm transition-colors " +
                  (active
                    ? "bg-sidebar-accent text-sidebar-accent-foreground"
                    : "text-muted-foreground hover:bg-sidebar-accent hover:text-sidebar-accent-foreground")
                }
              >
                <item.icon className="h-4 w-4" />
                {item.label}
              </Link>
            );
          })}
        </nav>

        <div className="border-t border-sidebar-border p-3">
          <div className="flex items-center gap-3 rounded-md p-2">
            <Avatar className="h-8 w-8">
              <AvatarFallback className="bg-accent text-xs">{initial}</AvatarFallback>
            </Avatar>
            <div className="min-w-0 flex-1">
              <p className="truncate text-sm font-medium">{me?.profile?.full_name ?? "—"}</p>
              <p className="truncate font-mono text-[11px] text-muted-foreground">
                {me?.isAdmin ? "admin" : me?.roles[0] ?? "viewer"}
              </p>
            </div>
            <Button variant="ghost" size="icon" className="h-8 w-8" onClick={signOut} aria-label="Sign out">
              <LogOut className="h-4 w-4" />
            </Button>
          </div>
        </div>
      </aside>

      <main className="flex-1 min-w-0">
        <header className="sticky top-0 z-10 flex h-14 items-center justify-between border-b border-border/50 bg-card/40 px-6 backdrop-blur-md">
          <div className="flex items-center gap-2 font-mono text-xs text-muted-foreground">
            <TrendingUp className="h-3.5 w-3.5" />
            <span>vector / production</span>
            <span className="ml-2 h-1.5 w-1.5 rounded-full bg-success" />
          </div>
          <div className="font-mono text-xs text-muted-foreground">
            {me?.profile?.email}
          </div>
        </header>
        <div className="p-6 md:p-10">
          <Outlet />
        </div>
      </main>
    </div>
  );
}
