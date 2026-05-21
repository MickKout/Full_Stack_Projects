# 🗺️ World Capitals Quiz — Full Stack

A small geography quiz app built with **Express + PostgreSQL** on the backend and **React** on the frontend.

## 🗂️ Project Structure

```
quiz-app/
├── backend/
│   ├── server.js        ← Express REST API
│   └── package.json
└── frontend/
    ├── src/
    │   ├── App.jsx                      ← Root component + state
    │   ├── App.css                      ← All styles
    │   ├── main.jsx                     ← React entry point
    │   └── components/
    │       ├── QuizCard.jsx             ← Question + answer form
    │       ├── ScoreBoard.jsx           ← Running score display
    │       ├── FeedbackBanner.jsx       ← Correct/wrong feedback
    │       └── LoadingSpinner.jsx       ← Loading state
    ├── index.html
    ├── vite.config.js   ← Dev proxy config
    └── package.json
```

## 🛠️ Prerequisites

- Node.js v18+
- PostgreSQL running locally
- A `world` database with a `capitals` table:

```sql
CREATE TABLE capitals (
  id      SERIAL PRIMARY KEY,
  country VARCHAR(100) NOT NULL,
  capital VARCHAR(100) NOT NULL
);

-- Sample data
INSERT INTO capitals (country, capital) VALUES
  ('France', 'Paris'),
  ('Germany', 'Berlin'),
  ('Japan', 'Tokyo');
```

## 🚀 Setup & Running

### 1. Backend

```bash
cd backend
npm install
npm run dev
# API running at http://localhost:3000
```

### 2. Frontend

```bash
cd frontend
npm install
npm run dev
# React app at http://localhost:5173
```

Open `http://localhost:5173` in your browser.

## 🔌 API Endpoints

| Method | Endpoint        | Description                         |
|--------|-----------------|-------------------------------------|
| GET    | /api/question   | Get a random country (no capital)   |
| POST   | /api/submit     | Check an answer → `{ correct, correctAnswer }` |
| GET    | /api/stats      | Get total question count            |

## 🔑 Key Architecture Decisions

| Concern          | EJS version         | React version               |
|------------------|---------------------|-----------------------------|
| Score tracking   | Server global var   | React `useState`            |
| Current question | Server global var   | React `useState`            |
| Rendering        | Server-side (EJS)   | Client-side (React)         |
| Multi-user safe  | ❌ No               | ✅ Yes                      |
| API style        | Renders HTML        | Returns JSON                |
