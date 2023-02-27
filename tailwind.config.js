module.exports = {
  content: [
    "./app/modules/Front/**/*.latte",
    "./app/modules/Front/**/*.js",
    "./dev/front/js/**/*.js",
  ],
  safelist: [],
  theme: {
    fontFamily: {
      sans: ["sans-serif"],
      serif: ["serif"],
    },
  },
  corePlugins: {
    container: false,
  },
  plugins: [
    require("@tailwindcss/aspect-ratio"),
    require("@tailwindcss/line-clamp"),
    require("@tailwindcss/forms"),
  ],
}
