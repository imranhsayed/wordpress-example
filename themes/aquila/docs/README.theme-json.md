# Theme.json - WordPress Design Tokens

The `theme.json` file defines WordPress design tokens that are automatically converted to CSS custom properties.

## Adding Brand Colors.

```json
  {
    "settings": {
      "color": {
        "defaultPalette": false,    // Disables WordPress default colors
        "text": false,              // Disables text color control
        "background": true,         // Enables background color control
        "link": false,              // Disables link color control
        "custom": false,            // Disables custom color picker
        "defaultGradients": false,  // Disables default gradients
        "palette": [
          {
            "slug": "foreground",
            "color": "#000",
            "name": "Foreground"
          },
          {
            "slug": "primary",
            "color": "#d9272d",
            "name": "Primary"
          },
          {
            "slug": "secondary",
            "color": "#f5f5f5",
            "name": "Secondary"
          }
          // ... more colors
        ]
      }
    }
  }
```

How to use:
- Colors will be available in the block editor color picker
- Accessible via CSS: var(--wp--preset--color--primary), var(--wp--preset--color--secondary), etc.
- The slug is used in CSS variables
- The name is what users see in the editor

## Spacing Presets

The theme defines 6 responsive spacing presets:

```json
{
  "settings": {
    "spacing": {
      "spacingSizes": [
        {"name": "1", "size": "10px", "slug": "10"},
        {"name": "2", "size": "20px", "slug": "20"},
        {"name": "3", "size": "clamp(24px, 2.5vw, 30px)", "slug": "30"},
        {"name": "4", "size": "clamp(30px, 3.5vw, 40px)", "slug": "40"},
        {"name": "5", "size": "clamp(40px, 4.4vw, 50px)", "slug": "50"},
        {"name": "6", "size": "clamp(48px, 5.4vw, 60px)", "slug": "60"}
      ]
    }
  }
}
```

### Usage in CSS/SCSS

```scss
.my-component {
  padding: var(--wp--preset--spacing--30);  // clamp(24px, 2.5vw, 30px)
  margin-bottom: var(--wp--preset--spacing--50);  // clamp(40px, 4.4vw, 50px)
}
```

### Benefits

- 🎨 **Consistent spacing** across the theme
- 📱 **Responsive values** using `clamp()` for larger sizes (30-60)
- 🔧 **Available everywhere** - both block editor and frontend
- ♿ **Better accessibility** and maintainability

### Preset Breakdown

| Slug | Size | Use Case |
|------|------|----------|
| `10` | `10px` | Minimal spacing, tight layouts |
| `20` | `20px` | Small gaps, compact elements |
| `30` | `clamp(24px, 2.5vw, 30px)` | Medium spacing, responsive |
| `40` | `clamp(30px, 3.5vw, 40px)` | Large spacing, responsive |
| `50` | `clamp(40px, 4.4vw, 50px)` | Extra large spacing, responsive |
| `60` | `clamp(48px, 5.4vw, 60px)` | Section spacing, responsive |

## Additional Resources

- [WordPress theme.json Documentation](https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-json/)
- [Spacing Settings Reference](https://developer.wordpress.org/block-editor/reference-guides/theme-json-reference/theme-json-living/#settings.spacing)

---

**Last Updated**: November 2025
