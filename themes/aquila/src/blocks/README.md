# WordPress Block Development Guide

This README explains how WordPress blocks work in this theme, focusing on styles, inner blocks, and server-side rendering.

## 📦 Table of Contents

1. [How WordPress Loads Block Styles](#how-wordpress-loads-block-styles)
2. [Save Function with InnerBlocks.Content](#save-function-with-innerblockscontent)
3. [How render.php Works](#how-renderphp-works)
4. [Dynamic vs Static Blocks](#dynamic-vs-static-blocks)
5. [Common Patterns](#common-patterns)

---

## 🎨 How WordPress Loads Block Styles

### Block.json Configuration

WordPress uses the `block.json` file to automatically load block styles. The `style` property tells WordPress which CSS file to load for the frontend.

```json
{
  "name": "aquila/accordion",
  "style": "file:./style.css",
  "editorStyle": "file:./index.css"
}
```

### How It Works

1. **Registration**: When `register_block_type_from_metadata()` is called, WordPress reads the `block.json` file
2. **Style Detection**: WordPress looks for the `style` property
3. **Automatic Enqueuing**: WordPress automatically enqueues the CSS file specified in `style` for both editor and frontend
4. **File Resolution**: The path is resolved relative to the `block.json` file location

### Important Points

- ✅ **File path must match**: The file path in `block.json` must match the actual CSS file in the build directory
  - ✅ Correct: `"style": "file:./style.css"` (matches Vite output)
  - ❌ Wrong: `"style": "file:./style-index.css"` (doesn't exist)

- ✅ **Automatic loading**: No need to manually enqueue styles - WordPress does it automatically
- ✅ **Editor vs Frontend**: 
  - `style`: Loads on both editor and frontend
  - `editorStyle`: Loads only in the editor

### File Structure

```
build/blocks/accordion/
├── block.json        ← WordPress reads this
├── style.css         ← Referenced in block.json as "file:./style.css"
├── index.css         ← Editor styles (if editorStyle is set)
└── index.js          ← Editor script
```

### Example: Accordion Block

**block.json:**
```json
{
  "name": "aquila/accordion",
  "style": "file:./style.css"
}
```

**What happens:**
1. WordPress registers the block from `block.json`
2. WordPress sees `"style": "file:./style.css"`
3. WordPress enqueues `build/blocks/accordion/style.css`
4. Styles are available on frontend automatically!

---

## 💾 Save Function with InnerBlocks.Content

### The Problem

When a block contains inner blocks (child blocks like paragraphs, headings, etc.), you need to tell WordPress how to save them. For dynamic blocks (server-side rendered), this is especially important.

### The Solution: `InnerBlocks.Content`

The `InnerBlocks.Content` component from `@wordpress/block-editor` saves the HTML content of all inner blocks to the database.

### Basic Usage

```javascript
import { InnerBlocks } from '@wordpress/block-editor';

export default function Save() {
  // Save inner blocks content (paragraphs, headings, etc.)
  return <InnerBlocks.Content />;
}
```

### How It Works

1. **Editor Side**: User adds inner blocks (paragraphs, headings, etc.) to your block
2. **Save Function**: When saving, `InnerBlocks.Content` serializes all inner blocks to HTML
3. **Database**: WordPress saves this HTML string to the `post_content` field
4. **Render.php**: The saved HTML is available via the `$content` variable

### Data Flow

```
Editor → User adds inner blocks (paragraphs, headings)
    ↓
Save Function → <InnerBlocks.Content /> serializes inner blocks to HTML
    ↓
Database → HTML string saved: "<p>Paragraph content</p>"
    ↓
Render.php → $content variable contains: "<p>Paragraph content</p>"
```

### Example: Accordion Item Block

**save.jsx:**
```javascript
import { InnerBlocks } from '@wordpress/block-editor';

export default function Save() {
  // Save inner blocks content so it's available in render.php via $content
  return <InnerBlocks.Content />;
}
```

**What happens:**
1. User adds a paragraph inside the accordion item
2. Save function runs: `<InnerBlocks.Content />`
3. Paragraph HTML is saved: `"<p>Some content</p>"`
4. In `render.php`: `$content` contains `"<p>Some content</p>"`

### For Dynamic Blocks

When using `render.php` (server-side rendering):

```javascript
// save.jsx - Still save inner blocks!
export default function Save() {
  // Even though block wrapper is server-rendered,
  // inner blocks content must be saved
  return <InnerBlocks.Content />;
}
```

**Why?**
- Block wrapper = rendered by `render.php` (dynamic)
- Inner blocks content = saved by `save()` function (static HTML)
- `$content` in `render.php` contains the saved inner blocks HTML

---

## 🔧 How render.php Works

### Overview

`render.php` is used for **dynamic blocks** - blocks that need server-side rendering. Instead of saving static HTML, WordPress calls your PHP file to render the block on each page load.

### When to Use render.php

- ✅ Block content changes based on server data
- ✅ Block needs WordPress functions (queries, user data, etc.)
- ✅ Block has complex PHP logic
- ✅ Block wrapper needs server-side rendering but inner blocks are static

### Block.json Configuration

```json
{
  "name": "aquila/accordion-item",
  "render": "file:./render.php"
}
```

### Available Variables

When `render.php` is called, WordPress provides these variables:

```php
<?php
/**
 * @var array<mixed> $attributes Block attributes (from block.json)
 * @var string       $content    Inner blocks HTML content (from save function)
 * @var WP_Block     $block      Block instance object
 */

// Access attributes
$title = $attributes['title'] ?? '';

// Access inner blocks content
$content = $content ?? ''; // Contains HTML from <InnerBlocks.Content />

// Access block object for advanced usage
$block_name = $block->name;
```

### How Inner Blocks Content Works

When `save()` returns `<InnerBlocks.Content />`:

1. **Save Phase**: Inner blocks are serialized to HTML
2. **Database**: HTML string is saved
3. **Render Phase**: WordPress passes saved HTML as `$content` to `render.php`

### Example: Accordion Item

**save.jsx:**
```javascript
export default function Save() {
  return <InnerBlocks.Content />;
}
```

**render.php:**
```php
<?php
$title = $attributes['title'] ?? '';
$content = $content ?? ''; // HTML from inner blocks (paragraphs, etc.)

// Render the block
?>
<div class="accordion-item">
  <h3><?php echo esc_html($title); ?></h3>
  <div class="accordion-content">
    <?php echo $content; // Output inner blocks HTML ?>
  </div>
</div>
```

### Handling Empty Content

Sometimes `$content` might be empty. You can manually render inner blocks:

```php
<?php
// Method 1: Use saved content (recommended)
$content = $content ?? '';

// Method 2: Render inner blocks manually if content is empty
if (empty(trim($content)) && !empty($block->inner_blocks)) {
    $content = '';
    foreach ($block->inner_blocks as $inner_block) {
        $content .= $inner_block->render();
    }
}

// Method 3: Fallback to inner_content array
if (empty(trim($content)) && isset($block->inner_content)) {
    $content = '';
    foreach ($block->inner_content as $inner_item) {
        if (is_string($inner_item)) {
            $content .= $inner_item;
        } elseif ($inner_item instanceof WP_Block) {
            $content .= $inner_item->render();
        }
    }
}
```

### Complete Example

**block.json:**
```json
{
  "name": "aquila/accordion-item",
  "render": "file:./render.php",
  "attributes": {
    "title": {
      "type": "string",
      "default": ""
    }
  }
}
```

**save.jsx:**
```javascript
import { InnerBlocks } from '@wordpress/block-editor';

export default function Save() {
  return <InnerBlocks.Content />;
}
```

**render.php:**
```php
<?php
/**
 * @var array<mixed> $attributes
 * @var string       $content
 * @var WP_Block     $block
 */

$title = $attributes['title'] ?? '';
$content = $content ?? '';

// Render inner blocks manually if content is empty
if (empty(trim($content)) && !empty($block->inner_blocks)) {
    $inner_content = '';
    foreach ($block->inner_blocks as $inner_block) {
        $inner_content .= $inner_block->render();
    }
    $content = $inner_content;
}
?>

<div class="accordion-item">
    <h3><?php echo esc_html($title); ?></h3>
    <div class="accordion-content">
        <?php echo wp_kses_post($content); ?>
    </div>
</div>
```

---

## 🔄 Dynamic vs Static Blocks

### Static Blocks

- **save()** returns JSX (HTML)
- Content is saved as static HTML in database
- No `render.php` needed
- Faster (no PHP processing)
- Less flexible (can't use server-side data)

```javascript
// save.jsx
export default function Save({ attributes }) {
    return (
        <div>
            <h2>{attributes.title}</h2>
        </div>
    );
}
```

### Dynamic Blocks

- **save()** returns `null` OR `<InnerBlocks.Content />`
- `render.php` file handles rendering
- Content can change based on server data
- More flexible but slower
- Use when you need WordPress functions

```javascript
// save.jsx
export default function Save() {
    return null; // OR return <InnerBlocks.Content /> for inner blocks
}
```

```php
// render.php
<?php
$title = $attributes['title'] ?? '';
// Can use WordPress functions: get_posts(), get_current_user(), etc.
?>
<div>
    <h2><?php echo esc_html($title); ?></h2>
</div>
```

### Hybrid Approach (Best for Inner Blocks)

When you need:
- Dynamic block wrapper (server-side)
- Static inner blocks content (paragraphs, etc.)

```javascript
// save.jsx
export default function Save() {
    // Save inner blocks as static HTML
    // Block wrapper rendered by render.php
    return <InnerBlocks.Content />;
}
```

```php
// render.php
<?php
// $content contains the saved inner blocks HTML
echo $content; // Output static inner blocks
?>
```

---

## 📋 Common Patterns

### Pattern 1: Simple Static Block

**Use when**: Block doesn't need server-side logic

```javascript
// save.jsx
export default function Save({ attributes }) {
    return <div>{attributes.text}</div>;
}
```

**No render.php needed**

### Pattern 2: Dynamic Block with Attributes Only

**Use when**: Block needs server-side rendering but no inner blocks

```javascript
// save.jsx
export default function Save() {
    return null; // Block rendered by render.php
}
```

```php
// render.php
<?php
$text = $attributes['text'] ?? '';
echo '<div>' . esc_html($text) . '</div>';
?>
```

### Pattern 3: Dynamic Block with Inner Blocks ⭐ (Recommended)

**Use when**: Block needs server-side wrapper but static inner content

```javascript
// save.jsx
import { InnerBlocks } from '@wordpress/block-editor';

export default function Save() {
    return <InnerBlocks.Content />; // Save inner blocks HTML
}
```

```php
// render.php
<?php
$title = $attributes['title'] ?? '';
$content = $content ?? ''; // Contains inner blocks HTML

// Handle empty content
if (empty(trim($content)) && !empty($block->inner_blocks)) {
    $content = '';
    foreach ($block->inner_blocks as $inner_block) {
        $content .= $inner_block->render();
    }
}
?>
<div class="wrapper">
    <h2><?php echo esc_html($title); ?></h2>
    <div class="content">
        <?php echo wp_kses_post($content); ?>
    </div>
</div>
```

---

## ✅ Checklist for Block Development

### Block Styles
- [ ] `block.json` has `"style": "file:./style.css"` (matches actual file name)
- [ ] CSS file exists in `build/blocks/[block-name]/style.css`
- [ ] Styles are loading on frontend (check browser inspector)

### Save Function
- [ ] If block has inner blocks, use `<InnerBlocks.Content />`
- [ ] If block is dynamic, return `null` or `<InnerBlocks.Content />`
- [ ] If block is static, return JSX with attributes

### render.php
- [ ] File exists if using dynamic rendering
- [ ] `block.json` has `"render": "file:./render.php"`
- [ ] Access attributes via `$attributes` array
- [ ] Access inner blocks via `$content` variable
- [ ] Handle empty `$content` if needed
- [ ] Escape output properly (`esc_html()`, `wp_kses_post()`)

---

## 🐛 Troubleshooting

### Styles Not Loading

**Problem**: Styles defined in `block.json` aren't loading

**Solutions**:
1. Check `block.json` file path matches actual CSS file
   - ✅ `"style": "file:./style.css"` when file is `style.css`
   - ❌ `"style": "file:./style-index.css"` when file is `style.css`
2. Verify CSS file exists in `build/blocks/[block-name]/style.css`
3. Check browser console for 404 errors
4. Clear WordPress cache/transients

### Inner Blocks Content Empty

**Problem**: `$content` is empty in `render.php`

**Solutions**:
1. Ensure `save.jsx` returns `<InnerBlocks.Content />`
2. Rebuild the block (`pnpm build`)
3. Re-save the post/page in WordPress
4. Add fallback code in `render.php` to manually render inner blocks

### Block Not Rendering

**Problem**: Block doesn't appear on frontend

**Solutions**:
1. Check `block.json` has `"render": "file:./render.php"`
2. Verify `render.php` file exists in build directory
3. Check for PHP errors (enable WordPress debug mode)
4. Ensure `register_block_type_from_metadata()` is called

---

## 📚 Additional Resources

- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [Block API Reference](https://developer.wordpress.org/block-editor/reference-guides/block-api/)
- [InnerBlocks Component](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#innerblocks)
- [Block Metadata](https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/)

---

**Last Updated**: November 2024



