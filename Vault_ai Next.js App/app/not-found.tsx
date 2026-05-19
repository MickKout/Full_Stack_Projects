import Link from 'next/link';

export default function NotFound() {
  return (
    <main className="grid min-h-screen place-items-center bg-slate-950 px-6 text-slate-100">
      <div className="max-w-xl rounded-[2rem] border border-slate-800 bg-slate-900/90 p-10 text-center">
        <p className="text-sm uppercase tracking-[0.4em] text-cyan-300">404</p>
        <h1 className="mt-4 text-4xl font-semibold">Page not found</h1>
        <p className="mt-4 text-slate-400">Sorry, the page you requested could not be found.</p>
        <Link href="/" className="mt-8 inline-flex rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white hover:bg-indigo-500">Return home</Link>
      </div>
    </main>
  );
}
