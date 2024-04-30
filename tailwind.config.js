/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");

export default {
  darkMode: 'class',
   presets: [
    //require("./vendor/wireui/wireui/tailwind.config.js"),
    require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
  ],
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Http/Livewire/**/*Table.php",
    "./vendor/power-components/livewire-powergrid/resources/views/**/*.php",
    "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php"
  ],
  safelist: [
      {
          pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
          variants: ['sm', 'md', 'lg', 'xl', '2xl'],
      },
  ],
  theme: {
    extend: {
      colors: {
          'pg-primary': colors.neutral,
          'pg-secondary': colors.blue,
      }
    },
  },
  plugins: [
  ],
}
