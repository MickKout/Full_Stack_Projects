import type { Metadata } from 'next';
import { ClerkProvider } from '@clerk/nextjs';
import './globals.css';
import { Toaster } from 'sonner';

export const metadata: Metadata = {
  title: 'VaultAI — Document Q&A for Teams',
  description: 'Upload documents, ask questions, and analyze your content with Claude-powered AI.',
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en">
      <body>
        <ClerkProvider>
          {children}
          <Toaster position="top-right" richColors />
        </ClerkProvider>
      </body>
    </html>
  );
}
