import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import DocumentChat from '@/components/dashboard/document-chat';

interface PageProps {
  params: { id: string };
}

export default async function DocumentPage({ params }: PageProps) {
  const { userId } = auth();
  const document = await prisma.document.findFirst({
    where: { id: params.id, user: { clerkId: userId ?? undefined } },
  });

  if (!document) {
    return <div className="rounded-[2rem] border border-slate-800 bg-slate-900/90 p-10 text-slate-300">Document not found.</div>;
  }

  return (
    <div className="grid gap-8 xl:grid-cols-[0.55fr_0.45fr]">
      <section className="rounded-[2rem] border border-slate-800 bg-slate-900/90 p-6">
        <h2 className="text-2xl font-semibold text-white">{document.name}</h2>
        <p className="mt-3 text-sm text-slate-400">Uploaded on {new Date(document.createdAt).toLocaleDateString()}</p>
        <div className="mt-6 space-y-4 rounded-3xl bg-slate-950/90 p-5 text-slate-300">
          <h3 className="text-lg font-semibold text-white">Document Summary</h3>
          <p className="whitespace-pre-wrap text-sm leading-7">{document.extractedText}</p>
        </div>
      </section>
      <section className="rounded-[2rem] border border-slate-800 bg-slate-900/90 p-6">
        <DocumentChat documentId={document.id} extractedText={document.extractedText} />
      </section>
    </div>
  );
}
