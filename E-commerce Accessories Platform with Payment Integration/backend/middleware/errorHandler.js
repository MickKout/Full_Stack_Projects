export const errorHandler = (err, req, res, next) => {
  const status = err.status || err.statusCode || 500;
  const message = err.message || 'Internal Server Error';

  console.error(`[Error] ${status} - ${message}`);

  // Database errors
  if (err.code === '23505') {
    return res.status(400).json({
      success: false,
      error: 'Email already exists',
      status: 400,
    });
  }

  if (err.code === '23503') {
    return res.status(400).json({
      success: false,
      error: 'Invalid reference',
      status: 400,
    });
  }

  // JWT errors
  if (err.name === 'JsonWebTokenError') {
    return res.status(401).json({
      success: false,
      error: 'Invalid token',
      status: 401,
    });
  }

  if (err.name === 'TokenExpiredError') {
    return res.status(401).json({
      success: false,
      error: 'Token expired',
      status: 401,
    });
  }

  // Default error response
  res.status(status).json({
    success: false,
    error: message,
    status: status,
    ...(process.env.NODE_ENV === 'development' && { stack: err.stack }),
  });
};
