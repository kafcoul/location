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
            fontFamily: {
                sans: ['Montserrat', ...defaultTheme.fontFamily.sans],
                display: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand': {
                    black: '#0a0a0a',
                    dark: '#111111',
                    gray: '#1a1a1a',
                    light: '#2a2a2a',
                    accent: '#ffffff',
                    muted: '#888888',
                    gold: '#c4a35a',
                },
            },
            letterSpacing: {
                'widest-plus': '0.2em',
            },
        },
    },

    plugins: [forms],
};
