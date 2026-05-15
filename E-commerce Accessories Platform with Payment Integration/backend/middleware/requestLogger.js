import morgan from 'morgan';

// Custom token to add color to HTTP method
morgan.token('method', (req) => {
  const method = req.method;
  let color = '\x1b[0m'; // Reset

  if (method === 'GET') color = '\x1b[36m'; // Cyan
  if (method === 'POST') color = '\x1b[32m'; // Green
  if (method === 'PUT') color = '\x1b[33m'; // Yellow
  if (method === 'DELETE') color = '\x1b[31m'; // Red

  return `${color}${method}\x1b[0m`;
});

// Custom token for status color
morgan.token('status', (req, res) => {
  let color = '\x1b[0m';
  const status = res.statusCode;

  if (status >= 500) color = '\x1b[41m'; // Red background
  else if (status >= 400) color = '\x1b[33m'; // Yellow
  else if (status >= 300) color = '\x1b[36m'; // Cyan
  else if (status >= 200) color = '\x1b[32m'; // Green

  return `${color}${status}\x1b[0m`;
});

// Create custom format
const customFormat = ':method :url :status :response-time ms';

export const requestLogger = morgan(customFormat, {
  skip: (req) => req.url === '/health', // Skip health checks
});
