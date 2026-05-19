'use client';

import { useState } from 'react';
import { toast } from 'sonner';
import { Button } from '@/components/ui/button';

interface SettingsFormProps {
  defaultName: string;
  defaultEmail: string;
}

export default function SettingsForm({ defaultName, defaultEmail }: SettingsFormProps) {
  const [name, setName] = useState(defaultName);
  const [email, setEmail] = useState(defaultEmail);
  const [loading, setLoading] = useState(false);

  async function handleSubmit(event: React.FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setLoading(true);
    try {
      const res = await fetch('/api/settings/update', {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, email }),
      });
      if (!res.ok) throw new Error('Unable to update');
      toast.success('Settings updated.');
    } catch (error) {
      toast.error('Settings update failed.');
    } finally {
      setLoading(false);
    }
  }

  async function deleteAccount() {
    if (!window.confirm('Delete your account and all data? This cannot be undone.')) return;
    setLoading(true);
    try {
      const res = await fetch('/api/account/delete', { method: 'POST' });
      if (!res.ok) throw new Error('Unable to delete account');
      toast.success('Account deleted.');
      window.location.href = '/';
    } catch (error) {
      toast.error('Could not delete account.');
    } finally {
      setLoading(false);
    }
  }

  return (
    <form className="space-y-8 rounded-[2rem] border border-slate-800 bg-slate-900/90 p-8" onSubmit={handleSubmit}>
      <div className="space-y-4">
        <div>
          <label className="mb-2 block text-sm font-medium text-slate-200">Display name</label>
          <input value={name} onChange={(event) => setName(event.target.value)} className="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none" />
        </div>
        <div>
          <label className="mb-2 block text-sm font-medium text-slate-200">Email</label>
          <input value={email} onChange={(event) => setEmail(event.target.value)} className="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none" />
        </div>
      </div>
      <div className="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <Button type="submit" disabled={loading}>{loading ? 'Saving…' : 'Save changes'}</Button>
        <Button variant="secondary" onClick={deleteAccount} disabled={loading}>Delete account</Button>
      </div>
    </form>
  );
}
