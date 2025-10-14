---
title: set_default_block_category
editLink: false
---

# set_default_block_category

## Description

The `set_default_block_category()` method sets the default category for all new blocks created with this plugin.

### Responsibility

This method allows you to configure which category blocks will be assigned to by default when they don't explicitly define their own category. It works by hooking into the `creode_blocks_default_category` filter. **This method must be called before blocks are initialized** to take effect.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$category` | `string` | Yes | The default category slug for new blocks (e.g., 'common', 'formatting', 'layout', or a custom category slug) |

### Return Value

- **Type**: `void`
- **Description**: Does not return a value, modifies block behavior via WordPress filters

## Examples

### Setting a Custom Default Category

```php
use Creode_Blocks\Helpers;

// Set the default category before initializing blocks
// This must be called early, typically in your theme's functions.php
// or plugin initialization

Helpers::set_default_block_category('my-custom-blocks');

// Now initialize your blocks
Your_First_Block::init();
Another_Block::init();

// Both blocks will use 'my-custom-blocks' category unless they override it
```

### Using a Core WordPress Category

```php
use Creode_Blocks\Helpers;

// Use a built-in WordPress block category
Helpers::set_default_block_category('design');

// All blocks without explicit category will appear under "Design"
```

### Theme Setup Integration

```php
use Creode_Blocks\Helpers;

// In your theme's functions.php
add_action('after_setup_theme', function() {
    // Set default category for theme blocks
    Helpers::set_default_block_category('my-theme-blocks');
    
    // Register the custom category
    add_filter('block_categories_all', function($categories) {
        return array_merge(
            [
                [
                    'slug' => 'my-theme-blocks',
                    'title' => 'My Theme Blocks',
                    'icon' => 'admin-customizer'
                ]
            ],
            $categories
        );
    });
});

// Later, when blocks are initialized
add_action('init', function() {
    Your_Block::init();
    // Will use 'my-theme-blocks' category
});
```

### Plugin-Specific Categories

```php
use Creode_Blocks\Helpers;

// In your plugin's main file
class My_Blocks_Plugin {
    
    public function __construct() {
        // Set default category early
        add_action('plugins_loaded', [$this, 'set_default_category'], 5);
        
        // Initialize blocks later
        add_action('init', [$this, 'init_blocks']);
    }
    
    public function set_default_category() {
        Helpers::set_default_block_category('my-plugin-blocks');
    }
    
    public function init_blocks() {
        // All these blocks will use 'my-plugin-blocks' category
        Contact_Form_Block::init();
        Gallery_Block::init();
        Testimonial_Block::init();
    }
}

new My_Blocks_Plugin();
```

### Conditional Category Assignment

```php
use Creode_Blocks\Helpers;

// Set different default categories based on environment
if (defined('WP_DEBUG') && WP_DEBUG) {
    Helpers::set_default_block_category('development-blocks');
} else {
    Helpers::set_default_block_category('production-blocks');
}
```

