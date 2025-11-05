#!/usr/bin/env node
/**
 * Component Generator Script
 *
 * This script helps scaffold new components for the WP Component Viewer.
 * Usage: npm run create-component -- --name=button --group="UI Elements"
 */

const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');

// Parse command line arguments
const args = process.argv.slice(2).reduce((result, arg) => {
    if (arg.startsWith('--')) {
        const [key, value] = arg.slice(2).split('=');
        result[key] = value || true;
    }
    return result;
}, {});

// Validate arguments
if (!args.name) {
    console.error(
        'Error: Component name is required. Use --name=componentName'
    );
    process.exit(1);
}

// Configuration
const componentName = args.name.toLowerCase();
const componentNameCamel = componentName.replace(/-([a-z])/g, (g) =>
    g[1].toUpperCase()
);
const componentNamePascal =
    componentNameCamel.charAt(0).toUpperCase() + componentNameCamel.slice(1);
const componentGroup = args.group || 'Components';
const componentPath = path.join(
    'themes',
    'test-theme',
    'components',
    componentName
);

// Check if component already exists
if (fs.existsSync(componentPath)) {
    console.error(
        `Error: Component "${componentName}" already exists at ${componentPath}`
    );
    process.exit(1);
}

// Create component directory
fs.mkdirSync(componentPath, { recursive: true });

// PHP Component template
const phpTemplate = `<?php
/**
 * @component ${componentNamePascal}
 * @description A reusable ${componentName} component
 * @group ${componentGroup}
 * @props {
 *   "text": {"type": "string", "required": true},
 *   "variant": {"type": "string", "options": ["primary", "secondary"]}
 * }
 * @variations {
 *   "default": {"text": "Default ${componentNamePascal}", "variant": "primary"},
 *   "secondary": {"text": "Secondary ${componentNamePascal}", "variant": "secondary"}
 * }
 * @example get_component('${componentName}', ['text' => 'Example Text']);
 */

// Default values
$text = $text ?? 'Default Text';
$variant = $variant ?? 'primary';

// Build class list
$class = '${componentName} ${componentName}--' . $variant;
?>

<div class="<?php echo esc_attr($class); ?>">
    <?php echo esc_html($text); ?>
</div>
`;

// CSS component template
const cssTemplate = `/**
 * ${componentNamePascal} Component Styles
 */
.${componentName} {
    display: inline-block;
    padding: 10px 15px;
    background-color: #f0f0f0;
    border-radius: 4px;

    &--primary {
        background-color: #0073aa;
        color: white;
    }

    &--secondary {
        background-color: #6c757d;
        color: white;
    }
}
`;

// JavaScript component template
const jsTemplate = `/**
 * ${componentNamePascal} Component JavaScript
 */
document.addEventListener('DOMContentLoaded', function() {
    const ${componentNameCamel}s = document.querySelectorAll('.${componentName}');

    ${componentNameCamel}s.forEach(element => {
        element.addEventListener('click', function() {
            console.log('${componentNamePascal} clicked:', this);
        });
    });
});
`;

// Write files
fs.writeFileSync(path.join(componentPath, 'index.php'), phpTemplate);
fs.writeFileSync(path.join(componentPath, 'index.css'), cssTemplate);
fs.writeFileSync(path.join(componentPath, 'index.js'), jsTemplate);

console.log(
    `✅ Component "${componentNamePascal}" created successfully at ${componentPath}`
);
console.log(`Files created:
- ${path.join(componentPath, 'index.php')}
- ${path.join(componentPath, 'index.css')}
- ${path.join(componentPath, 'index.js')}
`);
console.log(`You can now use this component by adding:
<?php echo get_component('${componentName}', ['text' => 'Your Text']); ?>
`);
