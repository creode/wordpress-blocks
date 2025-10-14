---
title: set_acf_block_mode
editLink: false
---

# set_acf_block_mode

## Description

The `set_acf_block_mode()` method configures the display mode for an ACF block in the WordPress editor.

### Responsibility

This method allows you to programmatically set how a specific ACF block appears in the block editor. It hooks into the block-specific ACF mode filter to control whether the block displays in preview mode (showing the rendered output) or edit mode (showing the field inputs). This is useful for dynamically controlling block behavior based on context or user permissions.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$block_name` | `string` | Yes | The full block name including vendor prefix (e.g., 'acf/my-block' or 'my-vendor/my-block') |
| `$mode` | `string` | No | The ACF block mode to set. Accepts 'preview', 'edit', or 'auto'. Defaults to 'preview' |

### Return Value

- **Type**: `void`
- **Description**: Does not return a value, modifies block behavior via WordPress filters

## Examples

### Setting Preview Mode

```php
use Creode_Blocks\Helpers;

// Force a block to always display in preview mode
Helpers::set_acf_block_mode('acf/hero-banner', 'preview');

// Users will see the rendered output, not the field editor
```

### Setting Edit Mode

```php
use Creode_Blocks\Helpers;

// Force a block to always display in edit mode
Helpers::set_acf_block_mode('acf/complex-form', 'edit');

// Users will see the ACF fields interface by default
```

### Conditional Mode Based on User Role

```php
use Creode_Blocks\Helpers;

// Show edit mode for administrators, preview for others
if (current_user_can('administrator')) {
    Helpers::set_acf_block_mode('acf/testimonial', 'edit');
} else {
    Helpers::set_acf_block_mode('acf/testimonial', 'preview');
}
```

### Auto Mode for User Preference

```php
use Creode_Blocks\Helpers;

// Use 'auto' mode to let users toggle between preview and edit
Helpers::set_acf_block_mode('acf/accordion', 'auto');

// Users can manually switch between modes using the block toolbar
```

### Setting Mode for Multiple Blocks

```php
use Creode_Blocks\Helpers;

// Configure mode for multiple blocks
$blocks = [
    'acf/card',
    'acf/pricing-table',
    'acf/team-member'
];

foreach ($blocks as $block_name) {
    Helpers::set_acf_block_mode($block_name, 'preview');
}
```

### Context-Specific Mode

```php
use Creode_Blocks\Helpers;

// Different modes for different post types
$current_post_type = get_post_type();

if ($current_post_type === 'landing-page') {
    // Simple blocks stay in preview for cleaner editing experience
    Helpers::set_acf_block_mode('acf/call-to-action', 'preview');
} else {
    // Other post types can edit directly
    Helpers::set_acf_block_mode('acf/call-to-action', 'edit');
}
```

### Plugin/Theme Initialization

```php
use Creode_Blocks\Helpers;

// In your theme's functions.php or plugin initialization
add_action('acf/init', function() {
    // Set default modes for all your custom blocks
    
    // Content blocks default to preview
    Helpers::set_acf_block_mode('my-theme/hero', 'preview');
    Helpers::set_acf_block_mode('my-theme/features', 'preview');
    
    // Form blocks default to edit for easier configuration
    Helpers::set_acf_block_mode('my-theme/contact-form', 'edit');
    Helpers::set_acf_block_mode('my-theme/newsletter-signup', 'edit');
});
```

### Development vs Production

```php
use Creode_Blocks\Helpers;

// Show edit mode in development, preview in production
$mode = (defined('WP_DEBUG') && WP_DEBUG) ? 'edit' : 'preview';

Helpers::set_acf_block_mode('acf/custom-block', $mode);
```

