module.exports = {
  purge: false,
  theme: {
    boxShadow: {
      xs: '0 0 0 1px rgba(0, 0, 0, 0.05)',
      sm: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
      default: '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)',
      md: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
      lg: '0 0 15px -3px rgba(0, 0, 0, 0.1), 0 0 6px -2px rgba(0, 0, 0, 0.05)',
      xl: '0 0 25px -5px rgba(0, 0, 0, 0.1), 0 0 10px -5px rgba(0, 0, 0, 0.04)',
      '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
      inner: 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
      outline: '0 0 0 3px rgba(66, 153, 225, 0.5)',
      none: 'none',
    },
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
    spacing: {
      '0': '0',
      '5': '5px',
      '11': '11px',
      '16': '16px',
      '20': '20px',
      '30': '30px',
      '40': '40px',
      '50': '50px',
      '75': '75px',
      px: '1px',
      '1': '0.25rem',
      '2': '0.5rem',
      '3': '0.75rem',
      '4': '1rem',
      '6': '1.5rem',
      '8': '2rem',
      '10': '2.5rem',
      '12': '3rem',
      '24': '6rem',
      '32': '8rem',
      '48': '12rem',
      '56': '14rem',
      '64': '16rem',
    },
    extend: {
        screens: {
            'xs': '375px',
            'dark': {'raw': '(prefers-color-scheme: dark)'},
        },
        minHeight: {
            '20': '20px',
            '30': '30px',
        },
        minWidth: {
            '20': '20px',
            '30': '30px',
        },
        borderWidth: {
            '5': '5px',
        },
        colors: {
          'prime': {
            100: '#F0EEFC',
            200: '#DAD4F7',
            300: '#C3BBF2',
            400: '#9787E8',
            500: '#6A54DE',
            600: '#5F4CC8',
            700: '#403285',
            800: '#302664',
            900: '#201943',
          },
        }
    }
  },
  variants: {
    backgroundColor: ['dark', 'dark-hover', 'odd' ],
    borderColor: ['dark', 'dark-focus',],
    textColor: ['dark', ]
  },
  plugins: [
    require('tailwindcss-dark-mode')(),
  ]
}
