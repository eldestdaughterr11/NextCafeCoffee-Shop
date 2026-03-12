/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        coffee: {
          50: '#fdf8f6',
          100: '#f2e8e5',
          200: '#eaddd7',
          300: '#d9beaf',
          400: '#c69276',
          500: '#af6f52',
          600: '#8c5039',
          700: '#6d3c2c',
          800: '#532e24',
          900: '#3a201a',
          950: '#251310',
        },
        cream: {
          50: '#fffcf5',
          100: '#fef7e0',
          200: '#fcebb8',
          300: '#fae090',
          400: '#f8d568',
        }
      },
    },
  },
  plugins: [],
};
