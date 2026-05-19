import { z } from 'zod';

const envSchema = z.object({
  NEXT_PUBLIC_CLERK_FRONTEND_API: z.string().min(1),
  CLERK_API_KEY: z.string().min(1),
  CLERK_JWT_KEY: z.string().min(1),
  CLERK_WEBHOOK_SECRET: z.string().min(1),
  DATABASE_URL: z.string().min(1),
  STRIPE_SECRET_KEY: z.string().min(1),
  STRIPE_WEBHOOK_SECRET: z.string().min(1),
  STRIPE_PRICE_PRO: z.string().min(1),
  STRIPE_PRICE_TEAM: z.string().min(1),
  NEXT_PUBLIC_UPLOADTHING_URL: z.string().min(1),
  UPLOADTHING_REACT_CLIENT: z.string().optional(),
  UPLOADTHING_SECRET: z.string().min(1),
  UPLOADTHING_CLIENT: z.string().min(1),
  UPLOADTHING_SECRET_KEY: z.string().min(1),
  ANTHROPIC_API_KEY: z.string().min(1),
  ANTHROPIC_MODEL: z.string().min(1),
  RESEND_API_KEY: z.string().min(1),
  RESEND_FROM: z.string().min(1),
  UPSTASH_REDIS_REST_URL: z.string().min(1),
  UPSTASH_REDIS_REST_TOKEN: z.string().min(1),
  NEXTAUTH_URL: z.string().optional(),
});

export const env = envSchema.parse(process.env);
