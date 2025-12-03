## Reason for keeping the component directory structure the way it is:

We use Component Co-location (Most Popular) pattern for each component directory. 
It keeps styles, logic, and templates together:
e.g.
components/tile-carousel/
├── index.js
├── index.scss
├── index.php

Used by:
- React ecosystem (Next.js, Gatsby, Create React App)
- Vue.js (Single File Components)
- Angular (component architecture)
- Modern WordPress themes with build tools
- Design systems (Shopify Aquila, Adobe Spectrum, Material UI)

Why it's popular:
- Easy to find all related files
- Easy to delete/move components
- Clear dependencies
- Better for teams and maintainability

For WordPress Specifically

Block Themes & Modern WordPress:
- Component co-location (what we're doing)
- Entry file imports styles: import './style.scss'
- Build tools (Vite, Webpack, Parcel)

Examples:
- @wordpress/scripts (official tooling) - uses Webpack with this exact pattern
- Modern WordPress starter themes (Sage, Timber) - component co-location
- WordPress.org block library - each block has index.js importing its styles
