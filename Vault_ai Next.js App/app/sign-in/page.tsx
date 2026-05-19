import { SignIn } from '@clerk/nextjs';

export default function SignInPage() {
  return (
    <main className="min-h-screen bg-slate-950 px-6 py-16 text-slate-100 sm:px-10">
      <div className="mx-auto max-w-md rounded-[2rem] border border-slate-800 bg-slate-900/95 p-10 shadow-glow">
        <div className="mb-8 space-y-3 text-center">
          <p className="text-sm uppercase tracking-[0.35em] text-cyan-300">VaultAI</p>
          <h1 className="text-3xl font-semibold">Sign in or create an account</h1>
          <p className="text-slate-400">Secure AI access for your documents and conversations.</p>
        </div>
        <SignIn path="/sign-in" routing="path" signUpUrl="/sign-in" />
      </div>
    </main>
  );
}
