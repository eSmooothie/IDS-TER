// execute: npx tailwindcss -i ./public_html/assets/css/input.css -o ./public_html/assets/css/output.css --watch
module.exports = {
  content: [
    "./app/Views/**/*.{php,html}",
    "./public_html/assets/js/*.js",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {},
    fontSize:{
      'xxs' : 'xx-small',
      'xs' : 'x-small',
      'sm': '.875rem',
      'base': '1rem',
      'lg': '1.125rem',
      'xl': '1.25rem',
      '2xl': '1.5rem',
      '3xl': '1.875rem',
      '4xl': '2.25rem',
      '5xl': '3rem',
      '6xl': '4rem',
      '7xl': '5rem',
    }
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}
