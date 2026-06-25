/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#142C14',
        secondary: '#4D2D18',
        tertiary: '#CACACA',
        neutral: '#0A0A0A',
        formBG: '#F9FAFB',
        inputBg: '#E5E5E5', 
      },
      fontFamily: {
        montserrat: ['Montserrat', 'sans-serif'],
        worksans: ['Work Sans', 'sans-serif'],
      }
    },
  },
  plugins: [],
}