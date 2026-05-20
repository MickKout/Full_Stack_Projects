'use client';

import { useEffect, useState } from 'react';
import { toast } from 'sonner';
import { Button } from '@/components/ui/button';

interface DocumentChatProps {
  documentId: string;
  extractedText: string;
}

interface Message {
  id: string;
  role: string;
  content: string;
  createdAt: string;
}

export default function DocumentChat({ documentId, extractedText }: DocumentChatProps) {
  const [query, setQuery] = useState('');
  const [messages, setMessages] = useState<Message[]>([]);
  const [loading, setLoading] = useState(false);

  async function loadHistory() {
    const res = await fetch(`/api/documents/${documentId}/messages`);
    if (res.ok) {
      const data = await res.json();
      setMessages(data.messages ?? []);
    }
  }

  useEffect(() => {
    loadHistory();
  }, [documentId]);

  async function handleSend(event: React.FormEvent<HTMLFormElement>) {
    event.preventDefault();
    if (!query.trim()) return;
    setLoading(true);
    const payload = { documentId, question: query };
    setMessages((current) => [...current, { id: crypto.randomUUID(), role: 'user', content: query, createdAt: new Date().toISOString() }]);
    try {
      const response = await fetch('/api/ai/stream', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
      if (!response.ok) throw new Error('Failed to send');

      const reader = response.body?.getReader();
      if (!reader) throw new Error('No stream available');

      const decoder = new TextDecoder();
      const assistantId = crypto.randomUUID();
      setMessages((current) => [...current, { id: assistantId, role: 'assistant', content: '', createdAt: new Date().toISOString() }]);

      while (true) {
        const { done, value } = await reader.read();
        if (done) break;
        const chunk = decoder.decode(value, { stream: true });
        setMessages((current) => current.map((m) => (m.id === assistantId ? { ...m, content: m.content + chunk } : m)));
      }

      setQuery('');
    } catch (error) {
      toast.error('Unable to send message.');
    } finally {
      setLoading(false);
    }
  }

  async function clearConversation() {
    const res = await fetch(`/api/documents/${documentId}/clear`, { method: 'POST' });
    if (res.ok) {
      setMessages([]);
      toast.success('Conversation cleared.');
    } else {
      toast.error('Could not clear conversation.');
    }
  }

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between gap-4">
        <div>
          <h2 className="text-xl font-semibold text-white">Chat with document</h2>
          <p className="text-sm text-slate-400">Your AI assistant uses document context for precise answers.</p>
        </div>
        <Button variant="secondary" onClick={clearConversation}>Clear conversation</Button>
      </div>
      <div className="space-y-4 rounded-3xl border border-slate-800 bg-slate-950/90 p-4">
        {messages.length === 0 ? (
          <p className="text-sm text-slate-400">No conversation yet. Ask your first question below.</p>
        ) : (
          messages.map((message) => (
            <div key={message.id} className={`rounded-3xl p-4 ${message.role === 'assistant' ? 'bg-slate-900 text-slate-100' : 'bg-slate-800/80 text-slate-200'}`}>
              <div className="mb-2 flex items-center justify-between text-xs uppercase tracking-[0.2em] text-slate-400">
                <span>{message.role}</span>
                <span>{new Date(message.createdAt).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
              </div>
              <p className="whitespace-pre-wrap text-sm leading-7">{message.content}</p>
            </div>
          ))
        )}
      </div>
      <form className="space-y-4" onSubmit={handleSend}>
        <div>
          <label className="mb-2 block text-sm font-medium text-slate-200">Ask a question</label>
          <textarea value={query} onChange={(event) => setQuery(event.target.value)} rows={4} className="w-full rounded-2xl border border-slate-700 bg-slate-950 px-4 py-3 text-sm text-slate-100 outline-none" placeholder="What are the key findings in this document?" />
        </div>
        <Button type="submit" disabled={loading}>{loading ? 'Thinking…' : 'Send question'}</Button>
      </form>
    </div>
  );
}
