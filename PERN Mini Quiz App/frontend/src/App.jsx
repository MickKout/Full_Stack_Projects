import { useState, useEffect, useCallback } from "react";
import QuizCard from "./components/QuizCard";
import ScoreBoard from "./components/ScoreBoard";
import FeedbackBanner from "./components/FeedbackBanner";
import LoadingSpinner from "./components/LoadingSpinner";
import "./App.css";

/**
 * App.jsx — Root component
 *
 * All quiz state lives here (in React), NOT on the server.
 * This fixes the original code's global state problem:
 * every user gets their own isolated state in their browser.
 *
 * State:
 *   question       — current { id, country } from API
 *   score          — number of correct answers (client-side)
 *   totalAnswered  — total questions attempted
 *   feedback       — null | { correct: bool, correctAnswer: string }
 *   loading        — whether a fetch is in progress
 *   error          — null | error message string
 *   totalQuestions — total questions available in DB
 */
export default function App() {
  const [question, setQuestion] = useState(null);
  const [score, setScore] = useState(0);
  const [totalAnswered, setTotalAnswered] = useState(0);
  const [feedback, setFeedback] = useState(null); // null = no feedback yet
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [totalQuestions, setTotalQuestions] = useState(0);

  // Base URL for the Express API
  const API_BASE = "http://localhost:3000";

  /**
   * fetchQuestion
   * Calls GET /api/question and updates the question state.
   * Wrapped in useCallback so it doesn't recreate on every render.
   */
  const fetchQuestion = useCallback(async () => {
    setLoading(true);
    setError(null);
    setFeedback(null); // Clear previous feedback when loading new question

    try {
      const res = await fetch(`${API_BASE}/api/question`);

      if (!res.ok) {
        throw new Error(`Server error: ${res.status}`);
      }

      const data = await res.json();
      setQuestion(data); // { id, country }
    } catch (err) {
      setError("Could not load question. Is the server running?");
      console.error("fetchQuestion error:", err);
    } finally {
      setLoading(false);
    }
  }, [API_BASE]);

  /**
   * fetchStats
   * Calls GET /api/stats to know total available questions.
   */
  const fetchStats = useCallback(async () => {
    try {
      const res = await fetch(`${API_BASE}/api/stats`);
      const data = await res.json();
      setTotalQuestions(data.totalQuestions);
    } catch (err) {
      console.error("fetchStats error:", err);
    }
  }, [API_BASE]);

  // On mount: load first question and stats
  useEffect(() => {
    fetchQuestion();
    fetchStats();
  }, [fetchQuestion, fetchStats]);

  /**
   * handleSubmit
   * Called when the user submits their answer.
   * POSTs to /api/submit, gets back { correct, correctAnswer }.
   * Updates score and feedback state — NO server state changed.
   */
  const handleSubmit = async (userAnswer) => {
    if (!question || loading) return;

    setLoading(true);

    try {
      const res = await fetch(`${API_BASE}/api/submit`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        // Send questionId so the server can look up the correct answer
        body: JSON.stringify({
          questionId: question.id,
          answer: userAnswer,
        }),
      });

      if (!res.ok) throw new Error(`Server error: ${res.status}`);

      const data = await res.json(); // { correct: bool, correctAnswer: string }

      // Update score entirely in React state
      setTotalAnswered((prev) => prev + 1);
      if (data.correct) {
        setScore((prev) => prev + 1);
      }

      // Show feedback for 1.5 seconds, then auto-advance
      setFeedback(data);
      setLoading(false);

      setTimeout(() => {
        fetchQuestion();
      }, 1500);
    } catch (err) {
      setError("Could not submit answer. Please try again.");
      setLoading(false);
      console.error("handleSubmit error:", err);
    }
  };

  /**
   * handleReset
   * Resets all client-side state and loads a fresh question.
   */
  const handleReset = () => {
    setScore(0);
    setTotalAnswered(0);
    setFeedback(null);
    fetchQuestion();
  };

  return (
    <div className="app">
      {/* Decorative background elements */}
      <div className="bg-decoration">
        <div className="globe globe-1">🌍</div>
        <div className="globe globe-2">🌎</div>
        <div className="globe globe-3">🌏</div>
      </div>

      <div className="app-inner">
        {/* Header */}
        <header className="header">
          <h1 className="app-title">
            <span className="title-icon">🗺️</span>
            World Capitals Quiz
          </h1>
          <p className="app-subtitle">
            Test your knowledge of capital cities
          </p>
        </header>

        {/* Score board — always visible */}
        <ScoreBoard
          score={score}
          totalAnswered={totalAnswered}
          totalQuestions={totalQuestions}
          onReset={handleReset}
        />

        {/* Feedback banner — shown briefly after each answer */}
        {feedback && <FeedbackBanner feedback={feedback} />}

        {/* Main quiz area */}
        <main className="main">
          {loading && !question ? (
            <LoadingSpinner message="Loading question..." />
          ) : error ? (
            <div className="error-card">
              <span className="error-icon">⚠️</span>
              <p>{error}</p>
              <button onClick={fetchQuestion} className="retry-btn">
                Try Again
              </button>
            </div>
          ) : (
            <QuizCard
              question={question}
              onSubmit={handleSubmit}
              loading={loading}
              feedback={feedback}
            />
          )}
        </main>

        {/* Footer */}
        <footer className="footer">
          <p>Data sourced from PostgreSQL · Express API on port 3000</p>
        </footer>
      </div>
    </div>
  );
}
