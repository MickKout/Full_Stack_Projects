**This full-stack application is a real-time chat app built with Next.js, TypeScript, Tailwind CSS, Prisma, and WebSockets.**

How it works, step by step:

1. Open the app in your browser at http://localhost:3000.
2. The main chat page loads and shows the current room, live message feed, and a message composer.
3. When you enter a display name and send a message, the app sends it through a WebSocket connection to the server.
4. The server receives the message, stores it in the chat store, and broadcasts it to everyone in the same room.
5. Other users see the new message instantly without refreshing the page.
6. Typing indicators are sent while you are composing a message, and room switching lets you move between chat spaces.
7. Messages can be persisted with Prisma and a database-backed store, while the app still supports a fallback mode if a database is not available yet.

This is a [Next.js](https://nextjs.org) project bootstrapped with [`create-next-app`](https://nextjs.org/docs/app/api-reference/cli/create-next-app).

## Getting Started

First, run the development server:

```bash
npm run dev
# or
yarn dev
# or
pnpm dev
# or
bun dev
```

Open [http://localhost:3000](http://localhost:3000) with your browser to see the result.

You can start editing the page by modifying `app/page.tsx`. The page auto-updates as you edit the file.

This project uses [`next/font`](https://nextjs.org/docs/app/building-your-application/optimizing/fonts) to automatically optimize and load [Geist](https://vercel.com/font), a new font family for Vercel.

## Learn More

To learn more about Next.js, take a look at the following resources:

- [Next.js Documentation](https://nextjs.org/docs) - learn about Next.js features and API.
- [Learn Next.js](https://nextjs.org/learn) - an interactive Next.js tutorial.

You can check out [the Next.js GitHub repository](https://github.com/vercel/next.js) - your feedback and contributions are welcome!

## Deploy on Vercel

The easiest way to deploy your Next.js app is to use the [Vercel Platform](https://vercel.com/new?utm_medium=default-template&filter=next.js&utm_source=create-next-app&utm_campaign=create-next-app-readme) from the creators of Next.js.

Check out [Next.js deployment documentation](https://nextjs.org/docs/app/building-your-application/deploying) for more details.
