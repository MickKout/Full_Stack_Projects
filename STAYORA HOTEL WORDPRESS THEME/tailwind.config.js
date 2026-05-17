/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './inc/**/*.php',
    './template-parts/**/*.php',
    './templates/**/*.php',
    './assets/js/**/*.js',
  ],
  darkMode: ['class', '[data-theme="dark"]'],
  theme: {
    extend: {
      colors: {
        gold:      '#c9a96e',
        champagne: '#e8d5b0',
        stone: {
          50:  '#f9f7f4',
          100: '#f0ede8',
          200: '#e4ddd4',
          300: '#cec4b9',
          400: '#b5a89a',
          500: '#9e9189',
          600: '#7a6d65',
          700: '#6b6460',
          800: '#3d3834',
          900: '#1a1916',
          950: '#0f0e0d',
        },
      },
      fontFamily: {
        display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
        body:    ['"DM Sans"', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        '7xl': ['4.5rem', { lineHeight: '1.05' }],
        '8xl': ['6rem',   { lineHeight: '1' }],
        '9xl': ['8rem',   { lineHeight: '1' }],
      },
      spacing: {
        '18': '4.5rem',
        '22': '5.5rem',
        '26': '6.5rem',
        '30': '7.5rem',
        '128': '32rem',
      },
      maxWidth: {
        'container': '1280px',
        'narrow':    '860px',
        'reading':   '680px',
      },
      transitionTimingFunction: {
        'bounce-sm': 'cubic-bezier(0.34, 1.56, 0.64, 1)',
        'smooth':    'cubic-bezier(0.4, 0, 0.2, 1)',
      },
      keyframes: {
        'fade-up': {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        'fade-in': {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        'slide-in-left': {
          '0%': { opacity: '0', transform: 'translateX(-24px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        'scale-up': {
          '0%': { opacity: '0', transform: 'scale(0.95)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        'shimmer': {
          '0%': { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
      },
      animation: {
        'fade-up':       'fade-up 0.6s ease forwards',
        'fade-in':       'fade-in 0.5s ease forwards',
        'slide-in-left': 'slide-in-left 0.5s ease forwards',
        'scale-up':      'scale-up 0.4s ease forwards',
        'shimmer':       'shimmer 2s linear infinite',
      },
      boxShadow: {
        'card':       '0 4px 24px rgba(26,26,26,0.08)',
        'card-hover': '0 12px 40px rgba(26,26,26,0.16)',
        'modal':      '0 20px 60px rgba(26,26,26,0.3)',
        'dark-card':  '0 4px 24px rgba(0,0,0,0.4)',
      },
      screens: {
        'xs': '480px',
      },
    },
  },
  plugins: [],
}
