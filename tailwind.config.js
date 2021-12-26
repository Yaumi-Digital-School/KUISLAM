const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            gridTemplateColumns:{
                '15': 'repeat(15, minmax(0, 1fr))',
            },
            width: {
                120: "30rem",
            },
            fontFamily: {
                poppins: ["Poppins"],
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                green: {
                    lightBg: "#8ACC3B",
                    darkBg: "#81C530",
                    nav: "#6DAF2B",
                    greenMain: "#52D876",
                    podium: "#52D876",
                },
                gray: {
                    nav: "#C4C4C4",
                    card: "#F5F5F5",
                    cardText: "#BEBEBE",
                    darkBg: "#F8F8F8",
                    lightBg: "#FBFBFB",
                    input: "rgba(196, 196, 196, 0.25)",
                    link: "#9B9B9B",
                },
                yellow: {
                    yellowMain: "#FFB73D",
                },
                red: {
                    redMain: "#FF6368",
                },
                blue: {
                    blueMain: "#2F83F9",
                },
                orange: {
                    podium: "#FFB436",
                },
            },
            screens: {
                "3xl": "1600px",
            },
            boxShadow: {
                profile: "0px 4px 4px rgba(0, 0, 0, 0.25)",
            },
            dropShadow: {
                profile: "0 1px 1px rgba(0, 0, 0, 0.1)",
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
