import { createFileRoute, redirect, useNavigate, Link } from "@tanstack/react-router";
import { useState, type FormEvent } from "react";
import { z } from "zod";
import { supabase } from "@/integrations/supabase/client";
import { lovable } from "@/integrations/lovable";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { toast } from "sonner";
import { ArrowRight, Loader2 } from "lucide-react";

export const Route = createFileRoute("/login")({
  validateSearch: z.object({
    redirect: z.string().optional().catch("/dashboard"),
    mode: z.enum(["signin", "signup"]).optional().catch("signin"),
  }),
  beforeLoad: async ({ search }) => {
    const { data } = await supabase.auth.getSession();
    if (data.session) throw redirect({ to: search.redirect || "/dashboard" });
  },
  component: LoginPage,
});

function LoginPage() {
  const search = Route.useSearch();
  const navigate = useNavigate();
  const [mode, setMode] = useState<"signin" | "signup">(search.mode ?? "signin");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [fullName, setFullName] = useState("");
  const [loading, setLoading] = useState(false);

  const onSubmit = async (e: FormEvent) => {
    e.preventDefault();
    setLoading(true);
    try {
      if (mode === "signup") {
        const { error } = await supabase.auth.signUp({
          email,
          password,
          options: {
            emailRedirectTo: `${window.location.origin}/dashboard`,
            data: { full_name: fullName },
          },
        });
        if (error) throw error;
        toast.success("Account created. Check your email to confirm.");
        setMode("signin");
      } else {
        const { error } = await supabase.auth.signInWithPassword({ email, password });
        if (error) throw error;
        toast.success("Welcome back");
        navigate({ to: search.redirect || "/dashboard" });
      }
    } catch (err) {
      toast.error(err instanceof Error ? err.message : "Authentication failed");
    } finally {
      setLoading(false);
    }
  };

  const onGoogle = async () => {
    setLoading(true);
    try {
      const res = await lovable.auth.signInWithOAuth("google", {
        redirect_uri: window.location.origin + "/dashboard",
      });
      if (res.error) throw res.error;
      if (res.redirected) return;
      navigate({ to: "/dashboard" });
    } catch (err) {
      toast.error(err instanceof Error ? err.message : "Google sign-in failed");
      setLoading(false);
    }
  };

  return (
    <div className="relative min-h-screen overflow-hidden text-foreground">
      <div className="absolute inset-0 bg-grid opacity-30" />

      <div className="relative grid min-h-screen lg:grid-cols-2">
        {/* Left brand panel */}
        <div className="hidden lg:flex flex-col justify-between border-r border-border/40 bg-card/30 backdrop-blur-xl p-10">
          <Link to="/" className="flex items-center gap-2">
            <div className="h-6 w-6 rotate-45 bg-foreground" />
            <span className="font-mono text-sm tracking-tight">VECTOR</span>
          </Link>
          <div>
            <p className="font-mono text-xs uppercase tracking-[0.2em] text-muted-foreground">
              Trading Operations Platform
            </p>
            <h2 className="mt-4 max-w-md text-3xl font-semibold leading-tight tracking-tight">
              The control plane for your trading desk.
            </h2>
            <p className="mt-3 max-w-md text-sm text-muted-foreground">
              Provision traders, manage roles, and monitor desk activity from a
              single signed-in surface.
            </p>
          </div>
          <div className="flex items-center gap-6 font-mono text-xs text-muted-foreground">
            <span>SOC 2 Type II</span>
            <span className="h-1 w-1 rounded-full bg-muted-foreground/40" />
            <span>SSO ready</span>
            <span className="h-1 w-1 rounded-full bg-muted-foreground/40" />
            <span>Audit logs</span>
          </div>
        </div>

        {/* Right form */}
        <div className="flex items-center justify-center p-6 lg:p-10">
          <div className="w-full max-w-sm rounded-2xl border border-border/40 bg-card/40 backdrop-blur-xl p-8 shadow-2xl">
            <div className="lg:hidden mb-8 flex items-center gap-2">
              <div className="h-6 w-6 rotate-45 bg-foreground" />
              <span className="font-mono text-sm tracking-tight">VECTOR</span>
            </div>

            <h1 className="text-2xl font-semibold tracking-tight">
              {mode === "signin" ? "Sign in to Vector" : "Create your account"}
            </h1>
            <p className="mt-2 text-sm text-muted-foreground">
              {mode === "signin"
                ? "Continue to your trading dashboard."
                : "First user becomes the workspace admin."}
            </p>

            <div className="mt-8 space-y-3">
              <Button
                variant="outline"
                className="h-10 w-full justify-center gap-2 border-border bg-card hover:bg-accent"
                onClick={onGoogle}
                disabled={loading}
              >
                <GoogleIcon />
                Continue with Google
              </Button>
            </div>

            <div className="relative my-6">
              <div className="absolute inset-0 flex items-center">
                <span className="w-full border-t border-border" />
              </div>
              <div className="relative flex justify-center">
                <span className="bg-background px-3 font-mono text-[10px] uppercase tracking-widest text-muted-foreground">
                  or with email
                </span>
              </div>
            </div>

            <form onSubmit={onSubmit} className="space-y-4">
              {mode === "signup" && (
                <div className="space-y-1.5">
                  <Label htmlFor="name">Full name</Label>
                  <Input
                    id="name"
                    value={fullName}
                    onChange={(e) => setFullName(e.target.value)}
                    required
                    placeholder="Ada Lovelace"
                    className="h-10 bg-card"
                  />
                </div>
              )}
              <div className="space-y-1.5">
                <Label htmlFor="email">Email</Label>
                <Input
                  id="email"
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  required
                  placeholder="you@desk.com"
                  className="h-10 bg-card"
                />
              </div>
              <div className="space-y-1.5">
                <Label htmlFor="password">Password</Label>
                <Input
                  id="password"
                  type="password"
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  required
                  minLength={6}
                  placeholder="••••••••"
                  className="h-10 bg-card"
                />
              </div>

              <Button type="submit" className="h-10 w-full gap-2" disabled={loading}>
                {loading ? <Loader2 className="h-4 w-4 animate-spin" /> : <ArrowRight className="h-4 w-4" />}
                {mode === "signin" ? "Sign in" : "Create account"}
              </Button>
            </form>

            <p className="mt-6 text-center text-sm text-muted-foreground">
              {mode === "signin" ? "New to Vector? " : "Already have an account? "}
              <button
                type="button"
                onClick={() => setMode(mode === "signin" ? "signup" : "signin")}
                className="text-foreground underline-offset-4 hover:underline"
              >
                {mode === "signin" ? "Create account" : "Sign in"}
              </button>
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}

function GoogleIcon() {
  return (
    <svg className="h-4 w-4" viewBox="0 0 24 24" aria-hidden>
      <path fill="#EA4335" d="M12 10.2v3.9h5.5c-.2 1.4-1.6 4.1-5.5 4.1-3.3 0-6-2.7-6-6.1s2.7-6.1 6-6.1c1.9 0 3.1.8 3.8 1.5l2.6-2.5C16.8 3.4 14.6 2.4 12 2.4 6.7 2.4 2.4 6.7 2.4 12s4.3 9.6 9.6 9.6c5.5 0 9.2-3.9 9.2-9.4 0-.6-.1-1.1-.2-1.7H12z"/>
    </svg>
  );
}
