/** @type {import('tailwindcss').Config} */
const fluid_type = require('tailwindcss-fluid-type');
const default_theme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
    './*.php',
    './**/*.php',
    'other-classes.txt',
  ],
  theme: {
    extend: {
      screens: {
        'md': '782px',
      },
      colors: {
        primary: {
          DEFAULT: '#b91c1c',
          600: '#3061AF',
          700: '#285192',
        },
                brand: {
                    rms: '#537307',
                    house: '#265e15',
                },
      },
            fontFamily: {
                sans: [ '"Brandon Text Regular"', ...default_theme.fontFamily.sans ],
                mono: [ 'MonoLisa', ...default_theme.fontFamily.mono ],
                caption: [ '"Brandon Text Bold"', ...default_theme.fontFamily.serif ],
                link: [ '"Brandon Text Bold"', ...default_theme.fontFamily.serif ],
                heading: [ '"Brandon Grotesque Condensed Bold"', ...default_theme.fontFamily.serif ],
            },
    },
  },
  corePlugins: {
    fontSize: false
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
    require('tailwindcss-debug-screens'),
    fluid_type({
        settings: {
            fontSizeMin: 1.25,
            fontSizeMax: 1.375,
            ratioMin: 1.125,
            ratioMax: 1.2,
            screenMin: 20,
            screenMax: 96,
            unit: 'rem',
            prefix: '',
                extendValues: false,
        },
    }),
  ],
}

