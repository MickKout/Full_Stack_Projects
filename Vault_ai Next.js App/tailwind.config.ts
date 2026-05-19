import type { Config } from 'tailwindcss';

const config: Config = {
  content: [
    './app/**/*.{js,ts,jsx,tsx}',
    './components/**/*.{js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      backgroundImage: {
        'hero-gradient': 'radial-gradient(circle at top, rgba(79,70,229,0.15), transparent 40%), radial-gradient(circle at 20% 30%, rgba(14,165,233,0.15), transparent 25%)',
      },
      boxShadow: {
        glow: '0 30px 80px rgba(99,102,241,0.15)',
      },
    },
  },
  plugins: [require('tailwindcss-animated')],
};

export default config;
