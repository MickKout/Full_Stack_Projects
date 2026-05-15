module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        surface: '#111827',
        surface2: '#1f2937',
        accent: '#7c3aed',
        accentSoft: '#c4b5fd',
        border: '#374151',
        muted: '#9ca3af'
      },
      boxShadow: {
        soft: '0 20px 60px rgba(15, 23, 42, 0.12)'
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif']
      }
    }
  },
  plugins: []
};
