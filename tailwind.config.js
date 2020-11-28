module.exports = {
  purge: [
      './resources/**/*.html',
      './resources/**/*.vue',
      './resources/**/*.blade.php',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
        spacing: {
            '35rem' : '35rem',
        },
        fontFamily: {
            'open-sans': ['Open Sans', 'sans-serif']
        }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
