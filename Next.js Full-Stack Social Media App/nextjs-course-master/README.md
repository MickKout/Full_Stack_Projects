<h1 align="center">✨ Next.js Social App ✨</h1>

![Demo App](/public/screenshot-for-readme.png)


Highlights:

- 🚀 Tech stack: Next.js App Router, Postgres, Prisma, Clerk & TypeScript
- 💻 Server Components, Layouts, Route Handlers, Server Actions
- 🔥 loading.tsx, error.tsx, not-found.tsx
- 📡 API Integration using Route Handlers
- 🔄 Data Fetching, Caching & Revalidation
- 🎭 Client & Server Components
- 🛣️ Dynamic & Static Routes
- 🎨 Styling with Tailwind & Shadcn
- 🔒 Authentication & Authorization
- 📤 File Uploads with UploadThing
- 🗃️ Database Integration with Prisma
- 🚀 Server Actions & Forms
- ⚡ Optimistic Updates

### Setup .env file

Create a file named `.env` in the `nextjs-course-master/` folder with these values:

```env
NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY=
CLERK_SECRET_KEY=
DATABASE_URL=
UPLOADTHING_TOKEN=
```

Fill in the values from the services below:

- `NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY` — Clerk publishable key
- `CLERK_SECRET_KEY` — Clerk secret key
- `DATABASE_URL` — PostgreSQL connection string
- `UPLOADTHING_TOKEN` — UploadThing token

### Install dependencies

From the `nextjs-course-master/` folder run:

```bash
npm install
```

This project runs `prisma generate` automatically after install.

### Initialize the database

After setting `DATABASE_URL`, initialize Prisma schema:

```bash
npx prisma db push
```

Or, if you prefer migrations:

```bash
npx prisma migrate dev --name init
```

### Run the app

Start the development server:

```bash
npm run dev
```

Then open:

```text
http://localhost:3000
```

### Required services

- Clerk: create a Clerk app and use its publishable and secret keys.
- PostgreSQL: provide a working `DATABASE_URL`.
- UploadThing: provide an `UPLOADTHING_TOKEN`.

### Notes

- The app uses Next.js 14 App Router.
- If startup fails, most likely the `.env` keys are missing or invalid.
- Make sure `http://localhost:3000` is allowed in Clerk configuration if needed.