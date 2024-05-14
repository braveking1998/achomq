import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
  ],
  safelist: [
    {
      pattern: /(hover:)?\!?(text|bg|border)-(red-500|green-500|blue-light)/,
    },
    "hover:text-blue-light",
    "hover:text-green-500",
    "hover:text-red-500",
  ],
  theme: {
    extend: {
      colors: {
        blue: {
          light: "#0D6FBC",
          dark: "#0D3F67",
          primary: "#2A386D",
        },
        pink: {
          primary: "#D97C7C",
        },
      },
      fontFamily: {
        sans: ["Figtree", ...defaultTheme.fontFamily.sans],
        farsi: ["Iransans", ...defaultTheme.fontFamily.sans],
      },
      screens: {
        xs: "390px",
      },
    },
  },

  plugins: [forms],
};
