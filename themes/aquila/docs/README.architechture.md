## Use of typescript.
We are using typescript extension for vite config, but not others because: 

vite.config.ts - It's beneficial to convert this to TypeScript because:
- Vite has excellent TypeScript support with full type definitions
- You get autocomplete and type checking for configuration options
- Catches configuration errors at development time
- This is a common practice in modern Vite projects

babel.config.js & postcss.config.js - These should stay as .js files because:
- They're simple configuration files that don't benefit much from TypeScript
- The standard practice in the ecosystem is to keep these as .js
- No significant type safety gains for these simple configs
- Less tooling complexity
