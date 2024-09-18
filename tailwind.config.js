import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
            primary: '#1D4ED8', // Example primary color
            secondary: '#9333EA', // Example secondary color
            accent: '#F59E0B', // Example accent color
            background: '#F3F4F6', // Background color
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'], // Example font family
          },
          boxShadow: {
            default: '0 4px 6px rgba(0, 0, 0, 0.1)', // Consistent shadow
          },
        },
      },
    plugins: [forms],
};
