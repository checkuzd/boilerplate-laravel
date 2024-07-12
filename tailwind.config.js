/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
                'no': 'Nunito, Arial, sans-serif',
                'ms': 'Montserrat, Arial, sans-serif',
                'gh': 'Grand Hotel, Arial, sans-serif',
            },
        },
    },
    plugins: [],
}

