const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            transform: ['hover', 'focus'],
            gridTemplateColumns: {
                15: "repeat(15, minmax(0, 1fr))",
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
                    leaderbord: "#F2FCD8",
                },
                gray: {
                    nav: "#C4C4C4",
                    card: "#FEFBFB",
                    cardText: "#BEBEBE",
                    darkBg: "#F8F8F8",
                    lightBg: "#FBFBFB",
                    input: "rgba(196, 196, 196, 0.25)",
                    inputDisabledBg: "#F6F6F6",
                    inputDisabledTxt: "#A8A8A8",
                    inputFileButton: "#D9D9D9",
                    inputFileButtonTxt: "#7A7A7A",
                    link: "#9B9B9B",
                    topicList: "#F5F5F5",
                    topicListTxt: "#656565",
                    avatar: "#CECDD2",
                },
                yellow: {
                    yellowMain: "#FFB73D",
                    avatar: "#F79429",
                },
                red: {
                    redMain: "#FF6368",
                },
                blue: {
                    blueMain: "#2F83F9",
                    facebook: "#4267B2",
                    facebookDark: "#3B5B9D",
                },
                orange: {
                    podium: "#FFB436",
                    avatar: "#FCC417",
                },
                brown: {
                    leaderboard : "#525252",
                }
            },
            screens: {
                "3xl": "1600px",
            },
            boxShadow: {
                profile: "0px 4px 4px 0 rgba(0, 0, 0, 0.25)",
                custom1: "0 2px 6px 0 rgba(0, 0, 0, 0.25)",
                card: "0 2px 8px 0 rgba(0, 0, 0, 0.25)",
                authPopup: "0 1px 4px 0 rgba(0, 0, 0, 0.5)",
                rank: "0 10px 10px 0 rgba(109, 109, 109, 0.5)",
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
