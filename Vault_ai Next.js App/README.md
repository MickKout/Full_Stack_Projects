# VaultAI

VaultAI is a production-ready Next.js 14 SaaS application for AI-powered document analysis, built with Clerk auth, PostgreSQL, Prisma, Stripe billing, Uploadthing storage, Anthropic Claude, Resend emails, and Upstash rate limiting.

## Features

- Marketing landing page with pricing, testimonials, FAQ
- Clerk authentication with protected dashboard
- Document upload and text extraction flow
- Conversation chat per document using Claude AI
- Stripe subscription billing and portal integration
- Usage limits and rate limiting by plan
- Transactional emails with Resend
- Responsive layout and error pages

## Local Setup

1. Install dependencies

   ```bash
   npm install
   ```

2. Create `.env.local` from `.env.example` and fill values.

3. Initialize Prisma and migrate

   ```bash
   npx prisma generate
   npx prisma migrate dev --name init
   npx ts-node --transpile-only prisma/seed.ts
   ```

4. Run the development server

   ```bash
   npm run dev
   ```

## Required Environment Variables

- `NEXT_PUBLIC_CLERK_FRONTEND_API`
- `CLERK_API_KEY`
- `CLERK_JWT_KEY`
- `CLERK_WEBHOOK_SECRET`
- `DATABASE_URL`
- `STRIPE_SECRET_KEY`
- `STRIPE_WEBHOOK_SECRET`
- `STRIPE_PRICE_PRO`
- `STRIPE_PRICE_TEAM`
- `NEXT_PUBLIC_UPLOADTHING_URL`
- `UPLOADTHING_SECRET`
- `UPLOADTHING_CLIENT`
- `UPLOADTHING_SECRET_KEY`
- `ANTHROPIC_API_KEY`
- `ANTHROPIC_MODEL`
- `RESEND_API_KEY`
- `RESEND_FROM`
- `UPSTASH_REDIS_REST_URL`
- `UPSTASH_REDIS_REST_TOKEN`

## Deployment

Please deploy on Vercel using the `main` branch and add all environment variables to the Vercel dashboard.

## Stripe Webhook Setup

Use the Stripe CLI or dashboard to add a webhook endpoint for:

- `/api/webhooks/stripe`

Enable events:

- `checkout.session.completed`
- `customer.subscription.updated`
- `customer.subscription.deleted`
- `invoice.payment_failed`

## Notes

- The upload flow is integrated with Uploadthing for secure uploads.
- Rate limiting is enforced in the AI route via Upstash Redis.
- Clerk user creation syncs metadata to Prisma via webhook.
