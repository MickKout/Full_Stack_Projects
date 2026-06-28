'use client';

import { FormEvent, useEffect, useMemo, useRef, useState } from "react";

type ChatMessage = {
  id: string;
  type: "message" | "system";
  username?: string;
  text: string;
  createdAt: string;
};

export default function Home() {
  const [messages, setMessages] = useState<ChatMessage[]>([]);
  const [text, setText] = useState("");
  const [username, setUsername] = useState("");
  const [status, setStatus] = useState("Connecting...");
  const socketRef = useRef<WebSocket | null>(null);

  const [guestName] = useState(
    () => `Guest${Math.floor(Math.random() * 9000) + 1000}`
  );

  const displayName = username || guestName;

  useEffect(() => {
    const protocol = window.location.protocol === "https:" ? "wss" : "ws";
    const ws = new WebSocket(`${protocol}://${window.location.host}/api/socket`);
    socketRef.current = ws;

    ws.onopen = () => setStatus("Connected");
    ws.onclose = () => setStatus("Disconnected");
    ws.onerror = () => setStatus("Connection error");

    ws.onmessage = (event) => {
      try {
        const message = JSON.parse(event.data) as ChatMessage;
        setMessages((current) => [...current, message]);
      } catch {
        // ignore invalid payloads
      }
    };

    return () => {
      ws.close();
    };
  }, []);

  const sendMessage = (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    if (!text.trim() || !socketRef.current || socketRef.current.readyState !== WebSocket.OPEN) {
      return;
    }

    const payload = {
      type: "message",
      username: displayName,
      text: text.trim(),
    };

    socketRef.current.send(JSON.stringify(payload));
    setText("");
  };

  return (
    <div className="min-h-screen bg-slate-950 text-slate-100">
      <div className="mx-auto flex min-h-screen max-w-6xl flex-col gap-8 px-4 py-6 sm:px-6 lg:px-8">
        <header className="rounded-3xl border border-white/10 bg-slate-900/70 p-8 shadow-2xl shadow-slate-950/30 backdrop-blur-xl">
          <div className="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
              <p className="text-sm uppercase tracking-[0.28em] text-cyan-400">Real-Time Chat</p>
              <h1 className="mt-4 text-4xl font-semibold tracking-tight text-white sm:text-5xl">
                Chat with your team instantly.
              </h1>
              <p className="mt-4 max-w-2xl text-slate-300">
                Enter a display name, connect with WebSockets, and share messages in real time.
              </p>
            </div>
            <div className="rounded-3xl bg-slate-800/90 p-5 ring-1 ring-white/10">
              <p className="text-xs uppercase tracking-[0.24em] text-slate-400">Status</p>
              <p className="mt-2 text-xl font-semibold text-white">{status}</p>
              <p className="mt-1 text-sm text-slate-400">{displayName}</p>
            </div>
          </div>
        </header>

        <main className="grid gap-8 lg:grid-cols-[1.5fr_0.9fr]">
          <section className="rounded-[2rem] bg-slate-900/95 p-6 ring-1 ring-white/10 shadow-2xl shadow-slate-950/20">
            <div className="mb-6 flex items-center justify-between gap-4">
              <div>
                <p className="text-sm uppercase tracking-[0.24em] text-slate-400">Live chat</p>
                <h2 className="mt-2 text-2xl font-semibold text-white">Message feed</h2>
              </div>
              <span className="rounded-full bg-cyan-500/15 px-4 py-2 text-sm text-cyan-200">
                {messages.length} messages
              </span>
            </div>

            <div className="max-h-[540px] space-y-4 overflow-y-auto pr-2 pb-2 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-950">
              {messages.map((message) => (
                <article
                  key={message.id}
                  className={`rounded-3xl border p-4 shadow-sm transition-all ${
                    message.type === "system"
                      ? "border-slate-700 bg-slate-800 text-slate-400"
                      : "border-slate-700/60 bg-slate-950"
                  }`}
                >
                  <div className="flex items-center justify-between gap-4 text-xs text-slate-500">
                    <span>{new Date(message.createdAt).toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}</span>
                    {message.type === "message" ? (
                      <span className="font-medium text-cyan-300">{message.username}</span>
                    ) : (
                      <span className="uppercase tracking-[0.2em] text-slate-500">System</span>
                    )}
                  </div>
                  <p className="mt-3 text-base leading-7 text-slate-200">{message.text}</p>
                </article>
              ))}
            </div>
          </section>

          <section className="rounded-[2rem] bg-slate-900/95 p-6 ring-1 ring-white/10 shadow-2xl shadow-slate-950/20">
            <div className="mb-6 space-y-4">
              <p className="text-sm uppercase tracking-[0.24em] text-slate-400">Your profile</p>
              <div className="space-y-3">
                <label className="block text-sm font-medium text-slate-300">Display name</label>
                <input
                  value={username}
                  onChange={(event) => setUsername(event.target.value)}
                  placeholder={displayName}
                  className="w-full rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-3 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20"
                />
              </div>
            </div>

            <form onSubmit={sendMessage} className="space-y-4">
              <label className="block text-sm font-medium text-slate-300">Message</label>
              <textarea
                rows={4}
                value={text}
                onChange={(event) => setText(event.target.value)}
                placeholder="Type your message here..."
                className="w-full resize-none rounded-3xl border border-white/10 bg-slate-950/80 px-4 py-4 text-white outline-none transition focus:border-cyan-400 focus:ring-2 focus:ring-cyan-500/20"
              />
              <button
                type="submit"
                className="inline-flex w-full items-center justify-center rounded-3xl bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-400"
              >
                Send message
              </button>
            </form>
          </section>
        </main>
      </div>
    </div>
  );
}
