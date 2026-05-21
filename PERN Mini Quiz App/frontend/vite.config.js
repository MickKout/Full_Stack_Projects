import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

/**
 * Vite Configuration
 *
 * The proxy setting is the KEY piece that makes React + Express work
 * cleanly in development without CORS issues.
 *
 * Any request from React that starts with /api is automatically
 * forwarded to http://localhost:3000 by the Vite dev server.
 * The browser never sees a cross-origin request.
 *
 * Example:
 *   React fetches /api/question
 *   Vite dev server forwards it to http://localhost:3000/api/question
 *   Response comes back transparently
 */
export default defineConfig({
  plugins: [react()],
  server: {
    port: 5173,
    proxy: {
      '/api': {
        target: 'http://localhost:3000',
        changeOrigin: true,
      }
    }
  }
})
