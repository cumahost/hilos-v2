/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.{html,php}", "./inc/**/*.{php,html}"],
  theme: {
    extend: {
      colors: {
        primary: '#d44601',
        secondary: '#177263',
      },
    },
  },
  plugins: [],
}

