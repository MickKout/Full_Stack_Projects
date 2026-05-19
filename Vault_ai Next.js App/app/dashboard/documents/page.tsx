import Link from 'next/link';
import { auth } from '@clerk/nextjs';
import { prisma } from '@/lib/prisma';
import { Button } from '@/components/ui/button';
import { Card, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import DocumentUpload from '@/components/dashboard/document-upload';

export default async function DocumentsPage() {
  const { userId } = auth();
  const user = await prisma.user.findUnique({
    where: { clerkId: userId ?? undefined },
    include: { documents: true },
  });

  const documents = user?.documents ?? [];

  return (
    <div className="space-y-10">
      <section className="grid gap-6 sm:grid-cols-2">
        <Card className="bg-slate-900/90 border-slate-800">
          <CardHeader>
            <CardTitle>Upload documents</CardTitle>
          </CardHeader>
          <CardDescription>Drop PDFs or documents to start a new AI chat session.</CardDescription>
          <div className="mt-6">
            <DocumentUpload />
          </div>
        </Card>

        <Card className="bg-slate-900/90 border-slate-800">
          <CardHeader>
            <CardTitle>Quick start</CardTitle>
          </CardHeader>
          <CardDescription>Upload a file, then open it to ask questions and inspect extracted text.</CardDescription>
          <div className="mt-6 space-y-4 rounded-3xl border border-slate-800 bg-slate-950/90 p-4">
            <p className="text-sm text-slate-400">Need help? Use the dashboard to upgrade your plan and track usage.</p>
            <Link href="/dashboard/billing">
              <Button variant="secondary">Manage billing</Button>
            </Link>
          </div>
        </Card>
      </section>

      <section className="space-y-6">
        <div className="flex items-center justify-between gap-4">
          <div>
            <h2 className="text-xl font-semibold text-white">Your documents</h2>
            <p className="text-sm text-slate-400">Open a document to chat with Claude or delete old uploads.</p>
          </div>
          <Link href="/dashboard/documents" className="text-sm text-cyan-300 hover:underline">Refresh list</Link>
        </div>

        <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
          {documents.length === 0 ? (
            <Card className="bg-slate-900/90 border-slate-800 p-8 text-center">
              <p className="text-slate-400">No documents uploaded yet. Use the form to upload your first document.</p>
            </Card>
          ) : (
            documents.map((document) => (
              <Card key={document.id} className="bg-slate-900/90 border-slate-800 p-6">
                <div className="flex items-start justify-between gap-4">
                  <div>
                    <h3 className="text-lg font-semibold text-white">{document.name}</h3>
                    <p className="mt-2 text-sm text-slate-400">Uploaded {new Date(document.createdAt).toLocaleDateString()}</p>
                  </div>
                  <Link href={`/dashboard/documents/${document.id}`} className="text-sm text-cyan-300 hover:underline">Open</Link>
                </div>
              </Card>
            ))
          )}
        </div>
      </section>
    </div>
  );
}
