/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors');

export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/Livewire/**/*Table.php',
    './app/Helpers/PowerGridThemes/*.php',
    './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
    './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
  ],
  darkMode: 'class',
  safelist: [
      {
          pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
          variants: ['sm', 'md', 'lg', 'xl', '2xl'],
      },
  ],
  presets: [
    require('./vendor/power-components/livewire-powergrid/tailwind.config.js'),
  ],
  theme: {
    extend: {
      colors: {
          'pg-primary': colors.neutral,
          'pg-secondary': colors.blue,
      }
    }
  }
}
