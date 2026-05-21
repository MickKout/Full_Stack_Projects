import { useState, useEffect, useRef } from "react";

/**
 * QuizCard
 *
 * Displays the current question and the answer input form.
 * Manages its own local `inputValue` state — only submits when user
 * clicks the button or presses Enter.
 *
 * Props:
 *   question  — { id, country }
 *   onSubmit  — (answer: string) => void
 *   loading   — bool, disables input while fetching
 *   feedback  — null | { correct, correctAnswer }
 */
export default function QuizCard({ question, onSubmit, loading, feedback }) {
  const [inputValue, setInputValue] = useState("");
  const inputRef = useRef(null);

  // Clear input when a new question loads
  useEffect(() => {
    setInputValue("");
    // Re-focus input for keyboard users
    if (inputRef.current && !loading) {
      inputRef.current.focus();
    }
  }, [question?.id, loading]);

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!inputValue.trim() || loading) return;
    onSubmit(inputValue.trim());
  };

  if (!question) return null;

  return (
    <div className={`quiz-card ${feedback ? (feedback.correct ? "correct" : "incorrect") : ""}`}>
      {/* Question prompt */}
      <div className="question-section">
        <p className="question-label">What is the capital of</p>
        <h2 className="country-name">{question.country}</h2>
        <span className="question-mark">?</span>
      </div>

      {/* Answer form */}
      <form onSubmit={handleSubmit} className="answer-form">
        <div className="input-group">
          <input
            ref={inputRef}
            type="text"
            value={inputValue}
            onChange={(e) => setInputValue(e.target.value)}
            placeholder="Type the capital city..."
            disabled={loading || !!feedback}
            className="answer-input"
            autoComplete="off"
            spellCheck="false"
          />
          <button
            type="submit"
            disabled={loading || !inputValue.trim() || !!feedback}
            className="submit-btn"
          >
            {loading ? "⏳" : "Submit"}
          </button>
        </div>

        {/* Hint about case insensitivity */}
        <p className="input-hint">Case-insensitive — any capitalisation works</p>
      </form>

      {/* Skip button */}
      {!feedback && !loading && (
        <button
          className="skip-btn"
          onClick={() => onSubmit("__skip__")}
          type="button"
        >
          Skip this question →
        </button>
      )}
    </div>
  );
}
