import Link from 'next/link';
import { Button } from '@/components/ui/button';
import { Card, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

const features = [
  { title: 'Automatic text extraction', description: 'Upload PDFs or docs and get searchable text instantly.' },
  { title: 'Claude-powered answers', description: 'Ask questions with up-to-date AI context from your documents.' },
  { title: 'Secure billing & subscriptions', description: 'Stripe billing with plans for Free, Pro, and Team.' },
];

const pricing = [
  { name: 'Free', price: '$0', description: 'Up to 3 documents, 20 questions/day', priceId: 'free' },
  { name: 'Pro', price: '$19', description: 'Up to 50 documents, 500 questions/day', priceId: 'pro' },
  { name: 'Team', price: '$49', description: 'Unlimited documents and AI usage', priceId: 'team' },
];

const faqs = [
  { question: 'Can I try VaultAI before subscribing?', answer: 'Yes — the Free plan includes 3 documents and a limited daily quota.' },
  { question: 'How is document text extracted?', answer: 'We extract text server-side and store it securely in your VaultAI workspace.' },
  { question: 'Can my team share documents?', answer: 'Team plans let you manage shared billing and collaboration through Stripe subscriptions.' },
];

export default function HomePage() {
  return (
    <main className="min-h-screen px-6 py-10 sm:px-10 lg:px-16">
      <header className="mx-auto flex max-w-7xl items-center justify-between gap-6 py-6 text-slate-100">
        <div>
          <p className="text-sm uppercase tracking-[0.4em] text-cyan-300">VaultAI</p>
          <h1 className="mt-3 text-4xl font-semibold tracking-tight sm:text-5xl">Secure document AI for fast answers.</h1>
        </div>
        <div className="flex items-center gap-3">
          <Link href="/sign-in" className="text-sm font-medium text-slate-200 hover:text-white">Sign in</Link>
          <Link href="/sign-in">
            <Button>Start free</Button>
          </Link>
        </div>
      </header>

      <section className="mx-auto grid max-w-7xl gap-16 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
        <div className="space-y-8">
          <div className="max-w-2xl space-y-6">
            <p className="inline-flex rounded-full bg-slate-900/80 px-4 py-1 text-sm font-semibold text-cyan-300 ring-1 ring-white/10">AI document analysis designed for teams</p>
            <h2 className="text-5xl font-semibold tracking-tight text-white sm:text-6xl">Upload documents and ask Claude to summarize, compare, or explain.</h2>
            <p className="max-w-xl text-lg leading-8 text-slate-300">VaultAI makes every document searchable and chat-ready, so your team gets answers faster with secure storage and subscription billing.</p>
          </div>

          <div className="flex flex-col gap-4 sm:flex-row">
            <Link href="/sign-in">
              <Button>Start for free</Button>
            </Link>
            <Link href="#pricing" className="text-sm font-semibold text-slate-200 underline underline-offset-4 decoration-slate-500/30">View pricing</Link>
          </div>
        </div>

        <div className="relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950/70 p-8 shadow-glow">
          <div className="absolute inset-x-0 top-0 h-48 bg-gradient-to-b from-sky-500/20 via-transparent to-transparent" />
          <div className="relative space-y-4">
            <div className="h-2 w-24 rounded-full bg-cyan-400/80" />
            <p className="text-sm uppercase tracking-[0.35em] text-slate-400">Dashboard preview</p>
            <div className="grid gap-4 rounded-[1.75rem] border border-slate-700/80 bg-slate-950/90 p-6">
              <div className="rounded-3xl bg-slate-900/80 p-5 text-slate-200 shadow-inner">Document upload progress and AI conversation workspace.</div>
              <div className="grid gap-3 rounded-3xl border border-slate-800/70 bg-slate-900/80 p-5">
                <div className="h-2 w-2/3 rounded-full bg-gradient-to-r from-cyan-400 to-indigo-500" />
                <p className="text-sm text-slate-400">Ask your document questions with context-aware AI.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="mx-auto mt-20 max-w-7xl space-y-12">
        <div className="grid gap-6 md:grid-cols-3">
          {features.map((feature) => (
            <Card key={feature.title} className="bg-slate-950/90 border-slate-800">
              <CardHeader>
                <CardTitle>{feature.title}</CardTitle>
              </CardHeader>
              <CardDescription>{feature.description}</CardDescription>
            </Card>
          ))}
        </div>
      </section>

      <section id="pricing" className="mx-auto mt-24 max-w-7xl space-y-10">
        <div className="space-y-4 text-center">
          <p className="text-sm uppercase tracking-[0.4em] text-cyan-300">Pricing</p>
          <h2 className="text-3xl font-semibold text-white">Plans that scale with your workload.</h2>
          <p className="max-w-2xl mx-auto text-slate-400">Start free and upgrade when you need more documents, AI queries, or team access.</p>
        </div>

        <div className="grid gap-6 lg:grid-cols-3">
          {pricing.map((plan) => (
            <Card key={plan.name} className="bg-slate-950/90 border-slate-800">
              <CardHeader>
                <p className="text-sm uppercase tracking-[0.35em] text-slate-400">{plan.name}</p>
                <div className="mt-4 flex items-end gap-2">
                  <span className="text-4xl font-semibold text-white">{plan.price}</span>
                  <span className="text-sm text-slate-500">/mo</span>
                </div>
              </CardHeader>
              <CardDescription>{plan.description}</CardDescription>
              <div className="mt-6">
                <Link href="/sign-in">
                  <Button className="w-full">Choose {plan.name}</Button>
                </Link>
              </div>
            </Card>
          ))}
        </div>
      </section>

      <section className="mx-auto mt-24 max-w-7xl space-y-10">
        <div className="grid gap-8 lg:grid-cols-2">
          <div className="rounded-[2rem] border border-slate-800 bg-slate-950/90 p-8">
            <h3 className="text-2xl font-semibold text-white">Trusted by knowledge workers</h3>
            <p className="mt-4 text-slate-400">VaultAI helps teams analyze contracts, reports, meeting notes, and research faster with secure AI workflows.</p>
            <div className="mt-8 space-y-4">
              <blockquote className="rounded-3xl border border-slate-800 bg-slate-900/80 p-6 text-slate-300">
                “VaultAI made it easy to find answers inside our product documentation without jumping between tools.”
              </blockquote>
              <p className="text-sm text-slate-500">— Jordan, Head of Operations</p>
            </div>
          </div>
          <div className="space-y-6">
            {faqs.map((faq) => (
              <div key={faq.question} className="rounded-3xl border border-slate-800 bg-slate-950/90 p-6">
                <p className="font-semibold text-white">{faq.question}</p>
                <p className="mt-3 text-slate-400">{faq.answer}</p>
              </div>
            ))}
          </div>
        </div>
      </section>
    </main>
  );
}
