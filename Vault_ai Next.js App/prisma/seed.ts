import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

async function main() {
  const user = await prisma.user.upsert({
    where: { email: 'demo@vaultai.com' },
    update: {},
    create: {
      clerkId: 'clerk_demo_user',
      email: 'demo@vaultai.com',
      name: 'Demo User',
      plan: 'free',
    },
  });

  await prisma.document.createMany({
    data: [
      {
        userId: user.id,
        name: 'Quarterly Report',
        url: 'https://example.com/sample.pdf',
        extractedText: 'This report summarizes revenue growth, customer retention, and AI adoption metrics for the quarter.',
      },
      {
        userId: user.id,
        name: 'Meeting Notes',
        url: 'https://example.com/notes.pdf',
        extractedText: 'Meeting notes with action items, next steps, and follow-up dates for the product launch.',
      },
    ],
  });
}

main()
  .catch((error) => {
    console.error(error);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
