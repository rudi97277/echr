/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        colors: {
            main: "#DC5F00",
            dark: "#373A40",
            mainPale: "#ffc45f",
            complement: "#0078ff",
            secondComplement: "#00ecc2",
            pale: "#EEEEEE",
            danger: "#D24545",
            secondary: "#2f4d2a",
        },
        extend: {
            fontFamily: {
                popins: ["Popins", "sans-serif"],
            },
        },
    },
    plugins: [require("flowbite/plugin")],
};
