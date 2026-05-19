import { Resend } from 'resend';
import { env } from './env';

const resend = new Resend(env.RESEND_API_KEY);

export function welcomeEmail(email: string, name: string) {
  return resend.emails.send({
    from: env.RESEND_FROM,
    to: email,
    subject: 'Welcome to VaultAI',
    html: `<h1>Welcome, ${name}</h1><p>Thanks for signing up. Upload a document to start asking questions instantly.</p>`,
  });
}

export function subscriptionConfirmation(email: string, plan: string) {
  return resend.emails.send({
    from: env.RESEND_FROM,
    to: email,
    subject: `Subscription active: ${plan}`,
    html: `<h1>Your VaultAI subscription is active</h1><p>Thank you for upgrading to ${plan}. You can manage billing from your dashboard.</p>`,
  });
}

export function paymentFailedEmail(email: string) {
  return resend.emails.send({
    from: env.RESEND_FROM,
    to: email,
    subject: 'Payment issue on your VaultAI subscription',
    html: `<h1>Payment failed</h1><p>We could not process your latest payment. Please update your billing details to keep access.</p>`,
  });
}
