import { createFileRoute } from "@tanstack/react-router";
import { queryOptions, useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { useServerFn } from "@tanstack/react-start";
import { getCurrentUserContext, updateProfile } from "@/lib/users.functions";
import { useEffect, useState } from "react";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { toast } from "sonner";

export const Route = createFileRoute("/_authenticated/settings")({
  component: SettingsPage,
});

function SettingsPage() {
  const qc = useQueryClient();
  const fetchMe = useServerFn(getCurrentUserContext);
  const save = useServerFn(updateProfile);
  const meQ = useQuery(queryOptions({ queryKey: ["me"], queryFn: () => fetchMe() }));

  const [fullName, setFullName] = useState("");
  const [desk, setDesk] = useState("");

  useEffect(() => {
    if (meQ.data?.profile) {
      setFullName(meQ.data.profile.full_name ?? "");
      setDesk(meQ.data.profile.desk ?? "");
    }
  }, [meQ.data]);

  const mutation = useMutation({
    mutationFn: async () =>
      save({ data: { userId: meQ.data!.userId, full_name: fullName, desk: desk || null } }),
    onSuccess: () => {
      toast.success("Profile updated");
      qc.invalidateQueries({ queryKey: ["me"] });
      qc.invalidateQueries({ queryKey: ["users"] });
    },
    onError: (e) => toast.error(e instanceof Error ? e.message : "Failed"),
  });

  return (
    <div className="mx-auto max-w-2xl space-y-8">
      <div>
        <p className="font-mono text-[11px] uppercase tracking-widest text-muted-foreground">Account</p>
        <h1 className="mt-2 text-3xl font-semibold tracking-tight">Settings</h1>
        <p className="mt-2 text-sm text-muted-foreground">Update your trader profile.</p>
      </div>

      <form
        onSubmit={(e) => { e.preventDefault(); mutation.mutate(); }}
        className="rounded-xl border border-border bg-card p-6 space-y-5"
      >
        <div className="space-y-1.5">
          <Label>Email</Label>
          <Input disabled value={meQ.data?.profile?.email ?? ""} className="h-10 bg-background font-mono text-sm" />
        </div>
        <div className="space-y-1.5">
          <Label htmlFor="fullName">Full name</Label>
          <Input id="fullName" value={fullName} onChange={(e) => setFullName(e.target.value)} className="h-10 bg-background" />
        </div>
        <div className="space-y-1.5">
          <Label htmlFor="desk">Trading desk</Label>
          <Input id="desk" value={desk} onChange={(e) => setDesk(e.target.value)} placeholder="e.g. FX Spot, Equities" className="h-10 bg-background" />
        </div>
        <div className="flex justify-end border-t border-border pt-4">
          <Button type="submit" disabled={mutation.isPending}>
            {mutation.isPending ? "Saving…" : "Save changes"}
          </Button>
        </div>
      </form>
    </div>
  );
}
