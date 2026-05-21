/**
 * Capital Cities Quiz - REST API Backend
 *
 * Refactored from EJS server-rendered app to a pure JSON API.
 * React frontend will consume these endpoints.
 *
 * Key changes from original:
 *  - No more EJS rendering (res.render removed)
 *  - No more global state (score/question now live in React)
 *  - CORS enabled so React dev server can call this API
 *  - pg.Pool used instead of pg.Client for proper connection handling
 *  - All routes return JSON
 */

import express from "express";
import cors from "cors";
import pg from "pg";

const app = express();
const port = 3000;

// ─── Database ────────────────────────────────────────────────────────────────
// pg.Pool is better than pg.Client:
//   - Keeps a pool of reusable connections instead of one single connection
//   - Handles reconnects automatically
//   - Safe for concurrent requests
const db = new pg.Pool({
  user: "postgres",
  host: "localhost",
  database: "world",
  password: "123456",
  port: 5432,
});

// ─── Middleware ───────────────────────────────────────────────────────────────

// CORS: Allow React dev server (port 5173) to call this API.
// Without this, browsers block cross-origin requests.
app.use(
  cors({
    origin: "http://localhost:5173", // Vite's default dev port
    methods: ["GET", "POST"],
  })
);

// Parse incoming JSON request bodies (React sends JSON, not form data)
app.use(express.json());

// ─── Routes ──────────────────────────────────────────────────────────────────

/**
 * GET /api/question
 *
 * Returns a single random country from the capitals table.
 * React calls this on mount and after each answer submission.
 *
 * Response:
 *   { id: 1, country: "France", capital: "Paris" }
 */
app.get("/api/question", async (req, res) => {
  try {
    // COUNT lets us pick a random offset without loading all rows
    const countResult = await db.query("SELECT COUNT(*) FROM capitals");
    const count = parseInt(countResult.rows[0].count);

    // Pick a random row using OFFSET
    const randomOffset = Math.floor(Math.random() * count);
    const result = await db.query(
      "SELECT * FROM capitals LIMIT 1 OFFSET $1",
      [randomOffset]
    );

    if (result.rows.length === 0) {
      return res.status(404).json({ error: "No questions found in database" });
    }

    // Only send country name — NOT the capital (that would give away the answer)
    const { id, country } = result.rows[0];
    res.json({ id, country });
  } catch (err) {
    console.error("Error fetching question:", err.message);
    res.status(500).json({ error: "Failed to fetch question" });
  }
});

/**
 * POST /api/submit
 *
 * Checks the user's answer against the database.
 * The score is tracked in React state, not on the server —
 * this endpoint only validates correctness.
 *
 * Request body:
 *   { questionId: 1, answer: "Paris" }
 *
 * Response:
 *   { correct: true, correctAnswer: "Paris" }
 */
app.post("/api/submit", async (req, res) => {
  const { questionId, answer } = req.body;

  // Input validation
  if (!questionId || !answer) {
    return res.status(400).json({ error: "questionId and answer are required" });
  }

  try {
    // Look up the correct answer by ID
    const result = await db.query(
      "SELECT capital FROM capitals WHERE id = $1",
      [questionId]
    );

    if (result.rows.length === 0) {
      return res.status(404).json({ error: "Question not found" });
    }

    const correctAnswer = result.rows[0].capital;

    // Case-insensitive comparison (same logic as original)
    const isCorrect =
      correctAnswer.toLowerCase().trim() === answer.toLowerCase().trim();

    res.json({
      correct: isCorrect,
      correctAnswer: correctAnswer, // Always send back correct answer for feedback
    });
  } catch (err) {
    console.error("Error checking answer:", err.message);
    res.status(500).json({ error: "Failed to check answer" });
  }
});

/**
 * GET /api/stats
 *
 * Returns aggregate stats about the quiz.
 * Useful for showing total number of questions available.
 *
 * Response:
 *   { totalQuestions: 195 }
 */
app.get("/api/stats", async (req, res) => {
  try {
    const result = await db.query("SELECT COUNT(*) FROM capitals");
    res.json({ totalQuestions: parseInt(result.rows[0].count) });
  } catch (err) {
    console.error("Error fetching stats:", err.message);
    res.status(500).json({ error: "Failed to fetch stats" });
  }
});

// ─── Start Server ─────────────────────────────────────────────────────────────
app.listen(port, () => {
  console.log(`🌍 Quiz API running at http://localhost:${port}`);
  console.log(`   GET  /api/question  → fetch a random question`);
  console.log(`   POST /api/submit    → check an answer`);
  console.log(`   GET  /api/stats     → get total question count`);
});
