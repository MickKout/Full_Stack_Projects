import { z } from 'zod';

export const documentUploadSchema = z.object({
  name: z.string().min(1),
  url: z.string().url(),
  extractedText: z.string().min(1),
});

export const conversationSchema = z.object({
  documentId: z.string().uuid(),
  question: z.string().min(1).max(1000),
});

export const settingsSchema = z.object({
  name: z.string().min(1).max(50),
  email: z.string().email(),
});

export const subscriptionSchema = z.object({
  priceId: z.string().min(1),
  successUrl: z.string().url(),
  cancelUrl: z.string().url(),
});
