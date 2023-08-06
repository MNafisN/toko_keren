/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'subTitle': '#406367',
        'footer': 'rgba(0,47,52,1)'
      }
    },
  },
  plugins: [],
}

