module.exports = {
  content: [
    "./app/modules/Front/**/*.latte",
    "./app/modules/Front/**/*.js",
    "./dev/front/js/**/*.js",
    "./app/modules/Admin/**/*.latte",
    "./app/modules/Admin/**/*.js",
    "./dev/admin/js/**/*.js",
  ],
  safelist: [],
  theme: {
    // OVERWRITE DEFAULT THEME
    fontFamily: {
      inter: ["Inter var, sans-serif"],
    },
    container: {
      center: true,
    },
    // EXTENDED DEFAULT THEME
    extend: {},
  },
  plugins: [
    require("@tailwindcss/aspect-ratio"),
    require("@tailwindcss/line-clamp"),
    require("@tailwindcss/forms"),
  ],
}
