/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        // powergrid
        './app/Http/Livewire/**/*Table.php',
        './app/Http/Livewire/PowerGridThemes/*.php',
        './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
        './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php',
        // wire-elements
        './vendor/wire-elements/modal/resources/views/*.blade.php',
        // wireui
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php'
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
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
}
