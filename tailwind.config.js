const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
module.exports = {
        presets: [
        require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
    ],

    theme: {
        extend: {
            colors: {
                "pg-primary": colors.gray,
            },
        },
    },

    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        // powergrid
        './app/Http/Livewire/**/*Table.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php',
        // wire elements modal
        './vendor/wire-elements/modal/resources/views/*.blade.php',
    ],
    darkMode: 'class',
    safelist: [
        {
            pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
            variants: ['sm', 'md', 'lg', 'xl', '2xl'],
        },
    ],
}
