/**
 * LoadingSpinner.jsx
 * Simple animated loading indicator.
 */
export default function LoadingSpinner({ message = "Loading..." }) {
  return (
    <div className="loading-container">
      <div className="spinner" aria-label="Loading" />
      <p className="loading-text">{message}</p>
    </div>
  );
}
