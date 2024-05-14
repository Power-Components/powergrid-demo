/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors');

export default {
  content: [
    './vendor/wireui/wireui/resources/**/*.blade.php',
    './vendor/wireui/wireui/ts/**/*.ts',
    './vendor/wireui/wireui/src/View/**/*.php',
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
    require('./vendor/wireui/wireui/tailwind.config.js'),
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
