import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            // fontFamily: {
            //     sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            // },
            colors: {
                yellow: {
                    300: 'rgb(253 224 71)',
                    400: 'rgb(250 204 21)'
                },
                emerald: {
                    300: 'rgb(110 231 183)',
                    400: 'rgb(52 211 153)'
                },
                blue: {
                    300: 'rgb(147 197 253)',
                    400: 'rgb(96 165 250)'
                },
                teal: {
                    300: 'rgb(94 234 212)',
                    400: 'rgb(45 212 191)'
                },
            },
        },
    },

    plugins: [forms],
};
