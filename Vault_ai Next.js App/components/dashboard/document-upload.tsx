'use client';

import { useState } from 'react';
import { toast } from 'sonner';
import { Button } from '@/components/ui/button';

export default function DocumentUpload() {
  const [name, setName] = useState('');
  const [file, setFile] = useState<File | null>(null);
  const [loading, setLoading] = useState(false);

  async function handleSubmit(event: React.FormEvent<HTMLFormElement>) {
    event.preventDefault();
    if (!file || !name) {
      toast.error('Please provide a document name and file.');
      return;
    }

    setLoading(true);
    const data = new FormData();
    data.append('name', name);
    data.append('file', file);

    try {
      const res = await fetch('/api/documents/upload', { method: 'POST', body: data });
      if (!res.ok) throw new Error('Upload failed');
      toast.success('Document uploaded successfully.');
      setName('');
      setFile(null);
    } catch (error) {
      toast.error('Upload failed. Please try again.');
    } finally {
      setLoading(false);
    }
  }

  return (
    <form className="space-y-4" onSubmit={handleSubmit}>
      <div>
        <label className="mb-2 block text-sm font-medium text-slate-200">Document name</label>
        <input value={name} onChange={(event) => setName(event.target.value)} className="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none" placeholder="Quarterly report" />
      </div>
      <div>
        <label className="mb-2 block text-sm font-medium text-slate-200">Choose file</label>
        <input type="file" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" onChange={(event) => setFile(event.target.files?.[0] ?? null)} className="w-full text-sm text-slate-200" />
      </div>
      <Button type="submit" disabled={loading}>{loading ? 'Uploading…' : 'Upload document'}</Button>
    </form>
  );
}
