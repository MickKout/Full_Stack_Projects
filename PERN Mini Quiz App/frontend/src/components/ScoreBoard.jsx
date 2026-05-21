/**
 * ScoreBoard.jsx
 *
 * Shows the user's running score, questions answered,
 * and a reset button. Receives all values as props from App —
 * this component has NO state of its own.
 */
export default function ScoreBoard({ score, totalAnswered, totalQuestions, onReset }) {
  const percentage = totalAnswered > 0
    ? Math.round((score / totalAnswered) * 100)
    : 0;

  return (
    <div className="scoreboard">
      <div className="score-item">
        <span className="score-label">✅ Correct</span>
        <span className="score-value score-correct">{score}</span>
      </div>

      <div className="score-divider" />

      <div className="score-item">
        <span className="score-label">📝 Attempted</span>
        <span className="score-value">{totalAnswered}</span>
      </div>

      <div className="score-divider" />

      <div className="score-item">
        <span className="score-label">🎯 Accuracy</span>
        <span className={`score-value ${percentage >= 70 ? "score-good" : percentage >= 40 ? "score-ok" : "score-bad"}`}>
          {percentage}%
        </span>
      </div>

      {totalQuestions > 0 && (
        <>
          <div className="score-divider" />
          <div className="score-item">
            <span className="score-label">🌍 Available</span>
            <span className="score-value">{totalQuestions}</span>
          </div>
        </>
      )}

      {totalAnswered > 0 && (
        <button className="reset-btn" onClick={onReset} title="Reset score">
          Reset
        </button>
      )}
    </div>
  );
}
