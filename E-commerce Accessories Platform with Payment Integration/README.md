# E-Commerce Accessories Platform

A modern full-stack e-commerce platform with Stripe payment integration, featuring React frontend with Tailwind CSS, TypeScript, and Node.js/Express backend with PostgreSQL database.

## 🎯 Features

### Frontend
- ✅ React 18 with TypeScript/TSX
- ✅ Vite build tooling (lightning-fast dev server)
- ✅ Tailwind CSS styling
- ✅ Stripe payment integration
- ✅ Authentication (JWT + refresh tokens)
- ✅ Responsive design

### Backend
- ✅ Express.js server
- ✅ PostgreSQL database
- ✅ JWT authentication with refresh token mechanism
- ✅ Stripe payment processing
- ✅ Input validation with express-validator
- ✅ Request logging with Morgan
- ✅ Rate limiting to prevent API abuse
- ✅ Global error handling
- ✅ Order tracking system

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **Node.js** v16+ ([Download](https://nodejs.org/))
- **PostgreSQL** v12+ ([Download](https://www.postgresql.org/download/))
- **npm** or **yarn** (comes with Node.js)
- **Stripe Account** ([Create one](https://dashboard.stripe.com/register))

---

## 🚀 Quick Start

### 1. Clone Repository

```bash
git clone <repository-url>
cd "E-commerce Accessories Platform with Payment Integration"
```

### 2. Database Setup

Create a PostgreSQL database:

```bash
createdb ecommerce_db
```

Apply schema:

```bash
psql -U postgres -d ecommerce_db -f backend/schema.sql
```

### 3. Backend Setup

```bash
cd backend

# Copy environment template
cp .env.example .env

# Edit .env with your configuration
# - DATABASE_URL: postgresql://user:password@localhost:5432/ecommerce_db
# - JWT_SECRET: your-secret-key (use something long and random)
# - STRIPE_SECRET_KEY: sk_test_... (from Stripe dashboard)
# - CLIENT_URL: http://localhost:5173

# Install dependencies
npm install

# Start development server
npm run dev
```

Server runs at `http://localhost:5000`

### 4. Frontend Setup

In a new terminal:

```bash
cd frontend

# Copy environment template
cp .env.example .env

# Edit .env with your configuration
# - VITE_API_URL: http://localhost:5000/api
# - VITE_STRIPE_PUBLISHABLE_KEY: pk_test_... (from Stripe dashboard)

# Install dependencies
npm install

# Start development server
npm run dev
```

Frontend runs at `http://localhost:5173`

---

## 🏗️ Project Structure

```
project-root/
├── frontend/
│   ├── src/
│   │   ├── components/          # Reusable components
│   │   │   ├── Navbar.tsx
│   │   │   ├── ProductForm.tsx
│   │   │   └── CheckoutForm.tsx
│   │   ├── pages/               # Page components
│   │   │   ├── Login.tsx
│   │   │   ├── Register.tsx
│   │   │   └── AdminDashboard.tsx
│   │   ├── App.tsx              # Main app component
│   │   ├── main.tsx             # React root entry
│   │   └── index.css            # Tailwind + custom styles
│   ├── index.html               # HTML entry point
│   ├── vite.config.ts           # Vite configuration
│   ├── tsconfig.json            # TypeScript configuration
│   ├── tailwind.config.js       # Tailwind CSS configuration
│   └── package.json
│
├── backend/
│   ├── controllers/             # Business logic
│   │   ├── authController.js
│   │   ├── productController.js
│   │   └── paymentController.js
│   ├── routes/                  # API routes
│   │   ├── authRoutes.js
│   │   ├── productRoutes.js
│   │   └── paymentRoutes.js
│   ├── middleware/              # Express middleware
│   │   ├── authMiddleware.js
│   │   ├── errorHandler.js
│   │   ├── requestLogger.js
│   │   ├── rateLimiter.js
│   │   └── validationMiddleware.js
│   ├── config/
│   │   └── db.js                # Database connection
│   ├── server.js                # Express app setup
│   ├── schema.sql               # Database schema
│   └── package.json
│
└── README.md
```

---

## 🔐 Authentication Flow

### Registration

```
POST /api/auth/register
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secure_password",
  "role": "user"  // or "admin"
}

Response:
{
  "success": true,
  "user": { id, name, email, role },
  "token": "eyJhbGc...",          // Access token (7 days)
  "refreshToken": "eyJhbGc..."    // Refresh token (30 days)
}
```

### Login

```
POST /api/auth/login
{
  "email": "john@example.com",
  "password": "secure_password"
}

Response: Same as registration
```

### Refresh Token

```
POST /api/auth/refresh-token
{
  "refreshToken": "eyJhbGc..."
}

Response:
{
  "success": true,
  "token": "eyJhbGc...",  // New access token
  "user": { id, name, email, role }
}
```

### Logout

```
POST /api/auth/logout
{
  "refreshToken": "eyJhbGc..."
}
```

---

## 📦 API Endpoints

### Authentication

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/register` | Create new account |
| POST | `/api/auth/login` | Login user |
| POST | `/api/auth/refresh-token` | Get new access token |
| POST | `/api/auth/logout` | Revoke refresh token |

### Products

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/products` | Get all products |
| GET | `/api/products/:id` | Get product by ID |
| POST | `/api/products` | Create product (admin only) |
| PUT | `/api/products/:id` | Update product (admin only) |
| DELETE | `/api/products/:id` | Delete product (admin only) |

### Payments

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/payments/create-payment-intent` | Create Stripe payment intent |
| POST | `/api/payments/payment-success` | Record successful payment (protected) |
| GET | `/api/payments/orders` | Get user's order history (protected) |
| GET | `/api/payments/orders/:id` | Get order details (protected) |

---

## 🔑 Environment Variables

### Frontend (.env)

```env
VITE_API_URL=http://localhost:5000/api
VITE_STRIPE_PUBLISHABLE_KEY=pk_test_your_key_here
```

### Backend (.env)

```env
PORT=5000
DATABASE_URL=postgresql://user:password@localhost:5432/ecommerce_db
JWT_SECRET=your_jwt_secret_change_in_production
REFRESH_TOKEN_SECRET=your_refresh_secret_change_in_production
STRIPE_SECRET_KEY=sk_test_your_key_here
CLIENT_URL=http://localhost:5173
NODE_ENV=development
```

---

## 🧪 Testing

### Register a Test User

1. Navigate to http://localhost:5173
2. Click "Create Account"
3. Fill in registration form
4. You'll be logged in automatically

### Create a Test Product (Admin Only)

1. Register with `role: "admin"` in the database, or update a user's role:
   ```sql
   UPDATE users SET role = 'admin' WHERE email = 'admin@example.com';
   ```
2. Login as admin
3. Go to Admin Dashboard
4. Fill in product form and submit

### Test Payment

1. Login as regular user
2. Go to Checkout
3. Use Stripe test card: `4242 4242 4242 4242`
4. Any future expiry date and any CVC

---

## 📚 Stripe Test Cards

For testing in Stripe test mode:

| Card | Number | Result |
|------|--------|--------|
| Visa | 4242 4242 4242 4242 | Successful |
| Visa (SCA) | 4000 0025 0000 3155 | Requires auth |
| Declined | 4000 0000 0000 0002 | Declined |

Any expiry date in the future and any 3-digit CVC will work.

---

## 🐛 Troubleshooting

### Database Connection Error

```
Error: connect ECONNREFUSED 127.0.0.1:5432
```

**Solution:** Ensure PostgreSQL is running
```bash
# macOS (Homebrew)
brew services start postgresql

# Ubuntu/Debian
sudo service postgresql start

# Windows
# Start PostgreSQL service from Services app
```

### Port Already in Use

```
Error: listen EADDRINUSE: address already in use :::5000
```

**Solution:** Change PORT in .env or kill the process using the port

### Stripe API Errors

- Verify keys in .env are correct (from Stripe dashboard)
- Use test keys (sk_test_... and pk_test_...)
- Don't commit real keys to git

### CORS Errors

- Ensure `CLIENT_URL` in backend .env matches your frontend URL
- Check frontend `VITE_API_URL` matches backend URL

---

## 📖 Next Steps

- Add email notifications (SendGrid/Nodemailer)
- Implement product search and filtering
- Add shopping cart functionality
- Implement order cancellation/refunds
- Add admin order management dashboard
- Deploy to production (Vercel/Heroku/AWS)
- Set up SSL certificates
- Add unit tests
- Implement CI/CD pipeline

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Create a feature branch (`git checkout -b feature/amazing-feature`)
2. Commit changes (`git commit -m 'Add amazing feature'`)
3. Push to branch (`git push origin feature/amazing-feature`)
4. Open a Pull Request

---

## 📄 License

This project is open source and available under the MIT License.

---

## 📞 Support

For issues and questions, please:

1. Check existing issues on GitHub
2. Create a new issue with clear description
3. Include error messages and steps to reproduce

---

## 🙏 Acknowledgments

- [React](https://react.dev/) - UI library
- [Vite](https://vitejs.dev/) - Build tool
- [Tailwind CSS](https://tailwindcss.com/) - Styling
- [Express.js](https://expressjs.com/) - Backend framework
- [Stripe](https://stripe.com/) - Payment processing
- [PostgreSQL](https://www.postgresql.org/) - Database

---

**Last Updated:** May 15, 2026  
**Version:** 1.0.0
