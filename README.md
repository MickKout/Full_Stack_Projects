# Full-Stack Projects Overview

This workspace contains a set of full-stack application projects, each organized in its own folder. The root README below summarizes the main purpose, architecture, and key technologies for each app so you can quickly understand the collection and jump into the right project.

> Note: Several projects include internal README files and setup instructions. Use those files for detailed installation and running steps.

## Projects in this folder

### 1. `COCTAIL DB API PROJECT`
- **Purpose**: Cocktail Recipe Finder using the public TheCocktailDB API.
- **Stack**: Node.js + Express + EJS template engine + Axios + CSS.
- **Highlights**: random cocktail search, search by name, search by ingredient, recipe display, images, responsive UI.
- **Why it matters**: lightweight full-stack demo showing server rendering, API integration, route handling, and user-facing search forms.
- **Location**: `COCTAIL DB API PROJECT/`

### 2. `E-commerce Accessories Platform with Payment Integration`
- **Purpose**: Full-stack e-commerce store with authenticated users, products, and payment checkout.
- **Stack**: React + TypeScript + Tailwind CSS frontend; Node.js + Express backend; PostgreSQL; Stripe payments.
- **Highlights**: JWT authentication, refresh tokens, product management, order tracking, Stripe checkout, validation, request logging, rate limiting, global error handling.
- **Why it matters**: a complete commerce experience with separate frontend/backend architecture and real payment integration.
- **Location**: `E-commerce Accessories Platform with Payment Integration/`

### 3. `event-planner-nextjs_full-stack_app`
- **Purpose**: Event planning platform built with modern Next.js and database-backed authentication.
- **Stack**: Next.js App Router + TypeScript + Tailwind CSS + Prisma + PostgreSQL + NextAuth.
- **Highlights**: user authentication, event creation/editing, RSVP and attendee management, dashboard interfaces, filtering, responsive layout.
- **Why it matters**: represents a production-style event management app with full CRUD flows, database integration, and server-side app structure.
- **Location**: `event-planner-nextjs_full-stack_app/event-planner-next.js_main/`

### 4. `full_stack_eventnow app_lovable`
- **Purpose**: Event registration and check-in application with attendee tracking and analytics.
- **Stack**: Vite + React + Tailwind CSS frontend; Supabase backend for auth and data; QR-based check-in flows.
- **Highlights**: event creation, custom registration forms, public registration pages, confirmation email + QR issuance, attendee search/export, check-in scanning, analytics, company profile pages.
- **Why it matters**: practical event operations app demonstrating realtime registration, secure Supabase-based multi-tenant data, and mobile-friendly check-in.
- **Location**: `full_stack_eventnow app_lovable/eventnow-main/`

### 5. `Next.js Full-Stack Social Media App`
- **Purpose**: Social networking app built with Next.js App Router and server-side capabilities.
- **Stack**: Next.js + TypeScript + Tailwind CSS + Prisma + PostgreSQL + Clerk auth + UploadThing.
- **Highlights**: authentication, dynamic routes, file uploads, social feeds, server components, server actions, data caching/revalidation, modern Next.js conventions.
- **Why it matters**: showcases a Next.js-first architecture for a social feed app, including auth, uploads, database integration, and advanced routing.
- **Location**: `Next.js Full-Stack Social Media App/nextjs-course-master/`

### 6. `PERN Full-Stack E-commerce App`
- **Purpose**: Full-stack e-commerce marketplace with product, cart, order, and admin management.
- **Stack**: React frontend + Express/TypeScript backend + PostgreSQL + Clerk + Polar payments.
- **Highlights**: product catalog, shopping cart, checkout, order history, admin dashboard, live chat integration, image upload support, error monitoring.
- **Why it matters**: strong example of a PERN-style commerce stack with third-party integrations and a separate frontend/backend deployment model.
- **Location**: `PERN Full-Stack E-commerce App/northwind-store-master/`

### 7. `Vault_ai Next.js App`
- **Purpose**: AI-powered document analysis SaaS platform with subscription billing.
- **Stack**: Next.js + TypeScript + Tailwind CSS + Prisma + PostgreSQL + Clerk auth + Stripe + Uploadthing + Anthropic + Resend + Upstash.
- **Highlights**: marketing landing page, signup/login, document uploads, AI chat per document, Stripe subscriptions, usage limits, transactional emails, rate limiting.
- **Why it matters**: illustrates a complex SaaS workflow combining auth, file handling, billing, AI inference, and production-ready infrastructure.
- **Location**: `Vault_ai Next.js App/`

## How to use this workspace

1. Open the folder for the app you want to run.
2. Read that app's individual `README.md` or configuration files.
3. Install dependencies in the chosen app folder.
4. Configure environment variables if required.
5. Start the app using the scripts described in the app README.

## Notes

- Many apps use PostgreSQL, Prisma, or Supabase for data storage.
- Authentication is commonly implemented with Clerk, NextAuth, or Supabase.
- Several apps rely on third-party services such as Stripe, Uploadthing, Anthropic, Resend, and Polar.
- The best next step is to open the app folder and follow its own README for setup.
