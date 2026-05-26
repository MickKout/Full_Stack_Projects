# Vector — Trading Desk User Management Platform

A premium user management dashboard built for trading startups. Vector provides role-based access control, user provisioning, and workspace administration with a glassmorphism purple aesthetic inspired by Vercel's design language.

---

## Features

| Feature | Description |
|---------|-------------|
| **Authentication** | Email/password and Google OAuth sign-in with email verification |
| **Role-Based Access** | Three-tier roles: `admin`, `trader`, `viewer` managed via `user_roles` table |
| **User Management** | Admins can update member roles, suspend/activate accounts, and search/filter the member directory |
| **Profile Settings** | Users can update their display name and trading desk assignment |
| **Dashboard Overview** | Real-time stats cards showing total users, active traders, admins, and desk count |
| **Security-First RLS** | Row-level security with self-only read access and admin escalation via `has_role()` function |
| **Glassmorphism UI** | Purple aurora background, frosted glass panels, and premium dark theme |

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| Framework | [TanStack Start](https://tanstack.com/start) v1 (React 19 + Vite 7 + SSR/SSG) |
| Routing | TanStack Router (file-based) |
| Data Fetching | TanStack Query v5 |
| Server Functions | `createServerFn` from `@tanstack/react-start` |
| Styling | Tailwind CSS v4 with custom `oklch` design tokens |
| UI Components | Radix UI primitives via shadcn/ui |
| Backend / Auth | Lovable Cloud (Supabase) |
| Database | PostgreSQL with Row Level Security (RLS) |
| Fonts | Geist (Sans) + Geist Mono |

---

## Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                        CLIENT                                │
│  ┌──────────────┐  ┌──────────────┐  ┌─────────────────────┐ │
│  │   /login     │  │ /dashboard   │  │    /users           │ │
│  │   (public)   │  │ (auth shell) │  │    (auth shell)     │ │
│  └──────────────┘  └──────────────┘  └─────────────────────┘ │
│                         │                                    │
│                         ▼                                    │
│              ┌─────────────────────┐                       │
│              │   TanStack Query    │                       │
│              │   useServerFn(...)  │                       │
│              └─────────────────────┘                       │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼ RPC
┌─────────────────────────────────────────────────────────────┐
│                     SERVER FUNCTIONS                         │
│  src/lib/users.functions.ts                                  │
│  ├─ listUsers()        → SELECT profiles + user_roles      │
│  ├─ getCurrentUserContext() → profile + roles + isAdmin    │
│  ├─ updateUserStatus()  → UPDATE profiles.status            │
│  ├─ setUserRole()       → DELETE + INSERT user_roles        │
│  └─ updateProfile()     → UPDATE profiles                    │
│                                                              │
│  Middleware: requireSupabaseAuth (bearer token → userId)     │
│  Header injection: attachSupabaseAuth (src/start.ts)        │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼ SQL
┌─────────────────────────────────────────────────────────────┐
│                       DATABASE (RLS)                         │
│  public.profiles   ── auth.users mirror + full_name, desk  │
│  public.user_roles ── app_role enum per user               │
│  public.has_role() ── SECURITY DEFINER role check           │
└─────────────────────────────────────────────────────────────┘
```

---

## Database Schema

### `profiles`
| Column | Type | Notes |
|--------|------|-------|
| `id` | `uuid` | Primary key, mirrors `auth.users(id)` |
| `email` | `text` | User email (unique) |
| `full_name` | `text` | Display name |
| `desk` | `text` | Trading desk name (e.g. "FX Spot") |
| `status` | `user_status` | `active` \| `suspended` \| `pending` |
| `avatar_url` | `text` | Optional profile image |
| `created_at` / `updated_at` | `timestamptz` | Audit timestamps |

### `user_roles`
| Column | Type | Notes |
|--------|------|-------|
| `id` | `uuid` | Primary key |
| `user_id` | `uuid` | References `auth.users(id)` on delete cascade |
| `role` | `app_role` | `admin` \| `trader` \| `viewer` |

### Row-Level Security Policies

- **`profiles`** — Users can read only their own profile. Admins can read all profiles.
- **`user_roles`** — Users can read only their own role. Admins can read all roles.
- **`has_role()`** — SECURITY DEFINER function used by RLS policies to check role membership without recursion.

> ⚠️ The `has_role` function is intentionally restricted: `EXECUTE` is revoked from `PUBLIC` and `anon`, granted only to `authenticated` and `service_role`.

---

## File Structure

```
├── src/
│   ├── components/ui/          # shadcn/ui primitives (Button, Input, Select, etc.)
│   ├── integrations/
│   │   ├── lovable/            # Lovable Cloud OAuth helpers
│   │   └── supabase/
│   │       ├── client.ts       # Browser Supabase client
│   │       ├── client.server.ts # Admin/service-role client (server-only)
│   │       ├── auth-middleware.ts # Bearer token validation middleware
│   │       ├── auth-attacher.ts  # Injects auth header into serverFn RPCs
│   │       └── types.ts        # Generated DB types
│   ├── lib/
│   │   └── users.functions.ts  # All server functions (listUsers, setUserRole, etc.)
│   ├── routes/
│   │   ├── __root.tsx          # Root layout (html shell + providers + Toaster)
│   │   ├── index.tsx           # Marketing landing page
│   │   ├── login.tsx           # Auth page (sign-in / sign-up / Google OAuth)
│   │   ├── _authenticated.tsx  # Auth layout shell (sidebar + header + sign-out)
│   │   └── _authenticated/
│   │       ├── dashboard.tsx   # Overview with stat cards + recent signups
│   │       ├── users.tsx       # Member directory with search/filter/actions
│   │       └── settings.tsx    # Profile editing (name + desk)
│   ├── router.tsx              # TanStack Router bootstrap
│   ├── start.ts                # TanStack Start instance config
│   ├── server.ts               # SSR entry with error handling wrapper
│   └── styles.css              # Design tokens, glassmorphism, purple theme
├── supabase/
│   ├── migrations/             # SQL migrations (schema, RLS, grants)
│   └── config.toml             # Supabase project config
├── vite.config.ts              # TanStack Start + server entry config
└── wrangler.jsonc              # Cloudflare Workers deployment config
```

---

## Route Map

| Route | File | Access | Description |
|-------|------|--------|-------------|
| `/` | `index.tsx` | Public | Landing page with brand hero |
| `/login` | `login.tsx` | Public (redirects if authed) | Sign-in / sign-up with email, password, or Google |
| `/dashboard` | `_authenticated/dashboard.tsx` | Auth | Workspace overview with stats |
| `/users` | `_authenticated/users.tsx` | Auth | Member list with role/status management (admin write) |
| `/settings` | `_authenticated/settings.tsx` | Auth | Edit own profile |

All routes under `/_authenticated/*` use `beforeLoad` to redirect unauthenticated users to `/login` with a `redirect` query parameter.

---

## Authentication Flow

1. **Sign-up**: `supabase.auth.signUp()` → email confirmation required (no auto-confirm)
2. **Sign-in**: `supabase.auth.signInWithPassword()` → session stored in `localStorage`
3. **Google OAuth**: `lovable.auth.signInWithOAuth('google')` → redirects back, sets session
4. **Server call auth**: `attachSupabaseAuth` reads the browser session and injects `Authorization: Bearer <token>` into every `createServerFn` RPC call.
5. **Middleware validation**: `requireSupabaseAuth` validates the token server-side and exposes `{ supabase, userId, claims }` to the handler context.

---

## Design System

- **Theme**: Dark-only with deep purple-black base (`oklch(0.04 0.03 280)`)
- **Background**: Fixed radial-gradient aurora with three violet/purple glow layers
- **Surface**: `glass` utility class — `backdrop-blur(16px)` + translucent purple card fill
- **Typography**: Geist family, monospaced labels at `11px` uppercase with wide tracking
- **Border radius**: 0.5rem base (`--radius`)
- **Status colors**: `success` (green), `warning` (amber), `destructive` (red)

---

## Available Scripts

```bash
# Development server with HMR
bun dev

# Production build
bun run build

# Development build (with SSR)
bun run build:dev

# Lint
bun run lint

# Format with Prettier
bun run format
```

---

## Environment Variables

| Variable | Scope | Description |
|----------|-------|-------------|
| `VITE_SUPABASE_URL` | Browser + Server | Supabase project URL |
| `VITE_SUPABASE_PUBLISHABLE_KEY` | Browser + Server | Supabase anon/public key |
| `SUPABASE_SERVICE_ROLE_KEY` | Server only | Admin key (bypasses RLS) — never expose to client |

These are managed by Lovable Cloud automatically. Do not edit `.env` manually.

---

## Security Checklist

- [x] RLS enabled on all user-facing tables (`profiles`, `user_roles`)
- [x] `profiles.email` only readable by self or admin
- [x] `user_roles` only readable by self or admin
- [x] `has_role()` function restricted to `authenticated` + `service_role`
- [x] No auto-confirm email (users must verify)
- [x] Admin mutations protected server-side (no client-side role checks)
- [x] Server functions require `requireSupabaseAuth` middleware

---

## License

MIT — Built with [Lovable](https://lovable.dev).
