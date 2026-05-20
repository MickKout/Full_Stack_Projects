# ⚓ Harbor Market — Full Stack E-Commerce Platform

![Demo App](/frontend/public/screenshot-for-readme.png)

---

## ✨ Highlights:

- 🛒 Full stack e-commerce platform with a React storefront and Express API
- ⚛️ Frontend built with React, TanStack Query, Tailwind CSS & DaisyUI
- 🚀 Backend built with Express.js and TypeScript
- 🔐 Secure authentication powered by Clerk
- 🗄️ PostgreSQL database support
- 💳 Checkout and payments integration with Polar
- 📦 Product, cart, and order management flows
- 📊 Admin dashboard for product management
- 💬 Live customer support chat with Stream
- 📹 Optional video support for orders
- 📤 Image optimization and uploads with ImageKit
- 🚨 Monitoring and error reporting with Sentry
- ⚡ Modular development setup with separate backend and frontend apps

---

## 🧪 Environment Variables

### Backend (`/backend`)

Create a `.env` file in the `backend` folder with values for:

```bash
NODE_ENV=development
PORT=3001
DATABASE_URL=<your_postgresql_connection_string>

CLERK_PUBLISHABLE_KEY=<your_clerk_publishable_key>
CLERK_SECRET_KEY=<your_clerk_secret_key>
CLERK_WEBHOOK_SECRET=<your_clerk_webhook_secret>

SENTRY_DSN=<your_sentry_dsn>

STREAM_API_KEY=<your_stream_api_key>
STREAM_API_SECRET=<your_stream_api_secret>

IMAGEKIT_PUBLIC_KEY=<your_imagekit_public_key>
IMAGEKIT_PRIVATE_KEY=<your_imagekit_private_key>
IMAGEKIT_URL_ENDPOINT=<your_imagekit_url_endpoint>

FRONTEND_URL=http://localhost:5173

POLAR_ACCESS_TOKEN=<your_polar_access_token>
POLAR_WEBHOOK_SECRET=<your_polar_webhook_secret>
POLAR_API_BASE=https://api.polar.sh

POLAR_CHECKOUT_PRODUCT_ID=<your_product_id>
```

### Frontend (`/frontend`)

Create a `.env` file in the `frontend` folder with values for:

```bash
VITE_CLERK_PUBLISHABLE_KEY=<your_clerk_publishable_key>
VITE_SENTRY_DSN=<your_sentry_dsn>
VITE_API_URL=http://localhost:3001
```

> `VITE_API_URL` should point at your running backend instance.

---

## 🚀 Run the app locally

Open two terminals and start backend and frontend separately.

1. Backend:

```bash
cd backend
npm install
npm run dev
```

The backend listens on port `3001` by default.

2. Frontend:

```bash
cd frontend
npm install
npm run dev
```

The frontend runs with Vite, usually at `http://localhost:5173`.

---

## 🔧 Notes

- The backend and frontend are separate apps, so install dependencies in both folders.
- If your backend runs on a different port, update `VITE_API_URL` in `frontend/.env`.
- Make sure `FRONTEND_URL` in the backend `.env` matches the frontend origin.
- Use `npm run build` in each folder when you want to prepare production output.
