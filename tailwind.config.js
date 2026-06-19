import defaultTheme from 'tailwindcss/defaultTheme'
import forms from '@tailwindcss/forms'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    orange: '#FF6600',
                    'orange-dark': '#D9540A',
                },
                ink: '#1C1A17',
                paper: '#FBF8F3',
                'paper-warm': '#F2ECE1',
                forest: '#14532D',
                stone: '#6B6358',
                border: '#E5DDD0',
            },
            fontFamily: {
                display: ['Fraunces', ...defaultTheme.fontFamily.serif],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
        },
    },
    plugins: [forms],
}
