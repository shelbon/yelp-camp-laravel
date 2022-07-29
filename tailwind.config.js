/** @type {import('tailwindcss').Config} */
const config = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",],

    theme: {
        extend: {}
    },

    plugins: [require('@tailwindcss/forms')({ strategy: 'class' }), require('tailwindcss-logical')]
};

module.exports = config;
