'use client';
import { useEffect } from 'react';
import { useRouter } from 'next/navigation';

export default function Error({ error, reset }: { error: Error; reset: () => void }) {
  useEffect(() => {
    console.error(error);
  }, [error]);

  return (
    <main className="grid min-h-screen place-items-center bg-slate-950 px-6 text-slate-100">
      <div className="max-w-xl rounded-[2rem] border border-slate-800 bg-slate-900/90 p-10 text-center">
        <p className="text-sm uppercase tracking-[0.4em] text-cyan-300">Something went wrong</p>
        <h1 className="mt-4 text-3xl font-semibold">An unexpected error occurred.</h1>
        <p className="mt-4 text-slate-400">Please try again or refresh the page.</p>
        <div className="mt-8 flex justify-center gap-4">
          <button onClick={() => reset()} className="rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white hover:bg-indigo-500">Try again</button>
        </div>
      </div>
    </main>
  );
}
