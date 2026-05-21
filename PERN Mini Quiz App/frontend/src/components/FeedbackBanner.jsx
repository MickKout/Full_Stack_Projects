/**
 * FeedbackBanner.jsx
 *
 * Displays whether the last answer was correct or wrong.
 * Shown briefly after each submission, then cleared by App.
 *
 * Props:
 *   feedback — { correct: bool, correctAnswer: string }
 */
export default function FeedbackBanner({ feedback }) {
  if (!feedback) return null;

  return (
    <div className={`feedback-banner ${feedback.correct ? "feedback-correct" : "feedback-wrong"}`}>
      {feedback.correct ? (
        <>
          <span className="feedback-icon">🎉</span>
          <span className="feedback-text">Correct! Well done!</span>
        </>
      ) : (
        <>
          <span className="feedback-icon">❌</span>
          <span className="feedback-text">
            Not quite — the answer was{" "}
            <strong>{feedback.correctAnswer}</strong>
          </span>
        </>
      )}
      <span className="feedback-next">Next question loading…</span>
    </div>
  );
}
