# WP Component Viewer

A WordPress package that helps front-end developers build and view components in one place, similar to Storybook for React.

## Features

- Browse all your theme components in a single interface
- Document components with docblock annotations
- View component variations and interactive documentation
- Test different component states and prop configurations
- View source code and usage examples
- Organize components by groups
- Restricted access for administrators only

## Installation

### Using Composer

```bash
composer require wp-component-viewer
```

### Manual Installation

1. Download the package
2. Upload it to your `/wp-content/plugins/` directory
3. Activate the plugin through the WordPress admin interface

## Development Setup

We now use the WordPress `wp-env` for local development. Follow the steps below to set up your environment.

### Prerequisites

1. Install the WordPress environment CLI globally:
   ```bash
   npm install -g @wordpress/env
   ```

2. Ensure Docker is installed and running on your system. You can download Docker Desktop from [here](https://www.docker.com/products/docker-desktop/).

3. Clone this repository to your local machine.

### Setting Up the Environment

1. Start the WordPress environment:
   ```bash
   wp-env start
   ```

2. Access the WordPress site:
   - URL: `http://localhost:8888`
   - Admin Login: `admin / password`

3. Your plugin (`wp-component-viewer`) will be automatically loaded, and the theme (`test-theme`) will be activated.

### Development Workflow

1. **Building Assets**:
   ```bash
   npm run build
   ```

2. **Watching for Changes**:
   ```bash
   npm run dev
   ```

3. **Running Tests**:
   ```bash
   npm run test
   ```

4. **Stopping the Environment**:
   ```bash
   wp-env stop
   ```

5. **Destroying the Environment**:
   ```bash
   wp-env destroy
   ```

## Usage

### Accessing the Component Viewer

Once activated, you can access the component viewer in two ways:

1. **Admin Interface**: Go to WordPress admin → Components
2. **Front-end**: Visit `your-site.com/components`

Both interfaces display the same components but are styled differently.

### Creating Components

Components should be created in your theme's component directories:

- `/components/` - For general UI components
- `/blocks/` - For Gutenberg blocks
- `/templates/` - For page templates
- `/partials/` - For partial views

### Component Documentation

Components are documented using PHPDoc blocks with custom annotations:

```php
/**
 * @component Button
 * @description A reusable button component
 * @group UI Elements
 * @props {
 *   "text": {"type": "string", "required": true},
 *   "variant": {"type": "string", "options": ["primary", "secondary"]}
 * }
 * @variations {
 *   "default": {"text": "Default Button", "variant": "primary"},
 *   "secondary": {"text": "Secondary Button", "variant": "secondary"}
 * }
 * @example get_component('button', ['text' => 'Click Me']);
 */
```

#### Supported Annotations

| Annotation            | Required | Type     | Description                                                          | Example                                                                                                     |
| --------------------- | -------- | -------- | -------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------- |
| `@component`          | ✅        | `string` | Unique name of the component. Used for identification and rendering. | `@component Button`                                                                                         |
| `@description`        | ❌        | `string` | Short summary describing the purpose of the component.               | `@description A primary action button.`                                                                     |
| `@group`              | ❌        | `string` | Category name to group components (e.g., `UI Elements`, `Forms`).    | `@group UI Elements`                                                                                        |
| `@props`              | ❌        | `JSON`   | Defines accepted props with `type`, `required`, and `description`.   | <pre>@props {<br>  "label": { "type": "string", "required": true, "description": "Button text" }<br>}</pre> |
| `@variations`         | ❌        | `JSON`   | Named prop sets for rendering multiple variants of the component.    | <pre>@variations {<br>  "default": { "label": "Click Me" }<br>}</pre>                                       |
| `@example`            | ❌        | `PHP`    | Code snippet to manually render the component.                       | `@example render_component('button', null, ['label' => 'Click Me']);`                                       |
| `@additional_js`      | ❌        | `array`  | JS file paths (local or trusted external) to enqueue.                | `@additional_js ["/build/button.js", "https://cdn.example.com/lib.js"]`                                     |
| `@additional_css`     | ❌        | `array`  | CSS file paths (local or trusted external) to enqueue.                       | `@additional_css ["/build/button.css", "https://cdn.example.com/style.css"]`                                                                     |
| `@extra_allowed_tags` | ❌        | `JSON`   | Defines custom tags and attributes allowed by `wp_kses`.             | <pre>@extra\_allowed\_tags {<br>  "svg": { "class": true, "fill": true }<br>}</pre>                         |

### Using Components in Your Theme

The package provides helper functions to use components in your theme:

```php
// Render a component with props
echo get_component('button', [
    'text' => 'Click Me',
    'variant' => 'primary'
]);

// Find a component's file path
$path = locate_component('button');
```

### Customization

You can customize the component scanner to include additional directories:

```php
// Add in your theme's functions.php
add_filter('wp_component_viewer_scan_paths', function($paths) {
    $paths['css_build_path'] = '/path/to/custom/components/{{component_name}}/index.css';
    $paths['js_build_path'] = '/path/to/custom/components/{{component_name}}/index.js';
    return $paths;
});
```

## Component Structure

A typical component file should:

1. Start with a docblock comment that documents the component
2. Handle default prop values
3. Process props as needed
4. Render the component markup

Example:

```php
<?php
/**
 * @component Button
 * @description A reusable button component
 * @group UI Elements
 * @props {
 *   "text": {"type": "string", "required": true},
 *   "variant": {"type": "string", "options": ["primary", "secondary"]}
 * }
 * @variations {
 *   "default": {"text": "Default Button", "variant": "primary"},
 *   "secondary": {"text": "Secondary Button", "variant": "secondary"}
 * }
 * @example get_component('button', ['text' => 'Click Me']);
 */

// Default values
$text = $text ?? 'Button';
$variant = $variant ?? 'primary';

// Build class list
$button_class = 'wp-button wp-button--' . $variant;
?>

<button class="<?php echo esc_attr($button_class); ?>">
    <?php echo esc_html($text); ?>
</button>
```

## Performance Considerations

The component viewer caches the component registry using WordPress transients to improve performance. The cache is automatically cleared when:

1. A theme is switched
2. The plugin is activated/deactivated
3. The "Refresh Components" button is clicked in the admin interface

## License

This project is licensed under the GPL-2.0+ License.
