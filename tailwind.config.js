const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: 'class',
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            height: {
                'screen-4': 'calc( 100vh - 4rem - 1.25rem  )',
            },
            minHeight: theme => theme('customHeights'),
            maxHeight: theme => theme('customHeights'),
        },
        customHeights: {
            '0': '0',
            '1/4': '25%',
            '1/4screen': '25vh',
            '1/2': '50%',
            '1/2screen': '50vh',
            '3/4': '75%',
            '3/4screen': '75vh',
            'full': '100%',
            'screen': '100vh',
        },

    },

    variants: {
        extend: {
            opacity: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('tailwind-scrollbar')],
};
