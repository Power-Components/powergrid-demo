module.exports = {
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
        'sm:max-w-2xl'
    ]
}
