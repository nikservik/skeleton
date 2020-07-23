module.exports = {
  purge: [
    './resources/views/**/*.php',
    './vendor/nikservik/**/*.php',
  ],
  theme: {
    fontFamily: {
      sans: '"Cera Pro", "Helvetica Neue", Arial, sans-serif'
    },
    borderRadius: {
      none: '0',
      sm: '7px',
      default: '11px',
      md: '13px',
      lg: '21px',
      full: '9999px',
    },
    extend: {
        minHeight: {
            '20': '20px',
            '30': '30px',
        },
        minWidth: {
            '20': '20px',
            '30': '30px',
        },
    }
  },
  variants: {},
  plugins: []
}
