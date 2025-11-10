# How fonts are loaded

The fonts are defined directly in theme.json using the fontFace property. This is the modern
WordPress way to add custom fonts.

1. STORING THE FONTS 
Store the font files are stored in a directory( e.g. /src/fonts/ ):

```
  src/fonts/
  ├── lato/
  │   ├── light.woff2
  │   ├── light-italic.woff2
  │   ├── regular.woff2
  │   ├── regular-italic.woff2
  │   ├── bold.woff2
  │   └── bold-italic.woff2
  └── montserrat/
      ├── regular.woff2
      └── italic.woff2
```
2. DECLARING FOTS & DEFINING FONT PATH: 
Fonts are declared in theme.json (lines 149-231):
Ensure same path is defined in "src": ["file:./src/fonts/lato/light.woff2"] of the theme.json

```json
  {
    "settings": {
      "typography": {
        "fontFamilies": [
          {
            "fontFamily": "Lato, sans-serif",
            "name": "Body Font",
            "slug": "body",
            "fontFace": [
              {
                "fontFamily": "Lato",
                "fontStyle": "normal",
                "fontWeight": "300",
                "src": ["file:./src/fonts/lato/light.woff2"]
              },
              {
                "fontFamily": "Lato",
                "fontStyle": "normal",
                "fontWeight": "400",
                "src": ["file:./src/fonts/lato/regular.woff2"]
              },
              {
                "fontFamily": "Lato",
                "fontStyle": "normal",
                "fontWeight": "700",
                "src": ["file:./src/fonts/lato/bold.woff2"]
              }
            ]
          },
          {
            "fontFamily": "Monsterrat, sans-serif",
            "name": "Heading Font",
            "slug": "heading",
            "fontFace": [
              {
                "fontFamily": "Montserrat",
                "fontStyle": "normal",
                "fontWeight": "100 900",
                "src": ["file:./src/fonts/montserrat/regular.woff2"]
              }
            ]
          }
        ]
      }
    }
  }
```
3. APPLY THE FONTS
Now add the Global typography styles and Heading styles (h1-h6) font family for the heading elements, inside theme.json under styles

```json
  "styles": {
    "typography": {
      "fontFamily": "var(--wp--preset--font-family--body)",
      "fontSize": "var(--wp--preset--font-size--normal)",
      "fontWeight": "400",
      "lineHeight": "1.5"
    },
    "elements": {
      "h1": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontSize": "var(--wp--preset--font-size--xx-large)",
          "fontWeight": "600"
        }
      },
      "h2": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontSize": "var(--wp--preset--font-size--x-large)",
          "fontWeight": "600"
        }
      },
      "h3": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontSize": "var(--wp--preset--font-size--large)",
          "fontWeight": "600"
        }
      },
      "h4": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontSize": "var(--wp--preset--font-size--normal)",
          "fontWeight": "600"
        }
      },
      "h5": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontSize": "var(--wp--preset--font-size--small)",
          "fontWeight": "600"
        }
      },
      "h6": {
        "typography": {
          "fontFamily": "var(--wp--preset--font-family--heading)",
          "fontSize": "var(--wp--preset--font-size--small)",
          "fontWeight": "600"
        }
      }
    }
  }
```
The above section tells WordPress to actually apply the fonts:


How it works:
- file:./src/fonts/... - WordPress automatically converts this to the correct theme URL
- No PHP wp_enqueue_style() needed
- WordPress generates @font-face CSS rules automatically
- Fonts are available in editor and frontend
- Can be referenced using CSS variables: var(--wp--preset--font-family--body) or
  var(--wp--preset--font-family--heading)

This is the modern WordPress 6.0+ approach using theme.json instead of PHP enqueuing! 
