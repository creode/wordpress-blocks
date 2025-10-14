---
title: Block Library
editLink: false
---

# Block Library

## Overview

The Block Library is a collection of pre-built, production-ready blocks that provide common functionality for WordPress sites. These blocks are designed to be **extended and customized** for your specific project needs, rather than used directly as-is.

## Philosophy

Each block in the library serves as a **starting point** that you can:
- Extend with additional functionality
- Customize with your own styling
- Modify to fit your specific use cases
- Use as a reference for building similar blocks

These blocks are maintained within the plugin and include templates, assets (JavaScript/CSS), and comprehensive field definitions.

## How to Extend Library Blocks

### Basic Extension Pattern

To extend a library block, create a new class in your theme that extends the library block class:

```php
<?php
/**
 * Custom Site Header block
 *
 * @package My Theme
 */

namespace My_Theme\Blocks;

use Creode_Blocks\Site_Header_Block;

/**
 * Custom Site Header that extends the library block
 */
class Custom_Site_Header_Block extends Site_Header_Block {
    
    /**
     * Add or modify fields
     */
    protected function fields(): array {
        $fields = parent::fields();
        
        // Add your custom fields
        $fields[] = array(
            'key' => 'field_custom_header_option',
            'name' => 'custom_option',
            'label' => 'Custom Option',
            'type' => 'text',
        );
        
        return $fields;
    }
    
    /**
     * Add custom modifier classes
     */
    protected function modifier_classes(): array {
        $classes = parent::modifier_classes();
        
        if ($this->get_field('custom_option')) {
            $classes[] = 'has-custom-option';
        }
        
        return $classes;
    }
}
```

::: warning Important
**Do not override the `name()` function.** Template files reference blocks by name, and changing the name will break these references. The block name should remain consistent with the library block.
:::

### Initializing Your Extended Block

Once you've created your extended block class, initialize it in your theme's `functions.php`:

```php
<?php
// Include your custom block class
require_once get_template_directory() . '/blocks/site-header/class-custom-site-header-block.php';

// Initialize the block (can be called as soon as the theme loads)
\My_Theme\Blocks\Custom_Site_Header_Block::init();
```

### Adding Child Blocks

Extend the block with additional child blocks:

```php
protected function child_blocks(): array {
    $blocks = parent::child_blocks();
    
    // Add a custom child block
    $blocks[] = new \Creode_Blocks\Child_Block(
        'social-links',
        'Social Links',
        array(
            array(
                'key' => 'field_header_social_links',
                'name' => 'social_links',
                'label' => 'Social Links',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_social_url',
                        'name' => 'url',
                        'label' => 'URL',
                        'type' => 'url',
                    ),
                ),
            ),
        ),
        __DIR__ . '/templates/social-links.php'
    );
    
    return $blocks;
}
```

## Available Library Blocks

The following blocks are available in the library:

### [Site Header Block](/block-library/site-header)
A comprehensive header block with child blocks for logo, menus, and mobile menu toggle. Includes JavaScript for scroll interactions and sticky header functionality.

### [Desktop Menu Block](/block-library/desktop-menu)
A desktop navigation menu block with menu location selection. Includes the Menu Integration trait for easy menu rendering.

### [Mobile Menu Block](/block-library/mobile-menu)
A mobile navigation menu with JavaScript interactions for opening/closing and accessibility features. Supports custom menu walkers and configurations.

### [Post Listing Block](/block-library/post-listing)
A flexible post listing block that integrates with WordPress Query blocks. Supports custom sorting, metafield ordering, and complex nested layouts.

## Best Practices

1. **Always extend, never modify** - Don't edit library blocks directly; create extended versions in your theme
2. **Don't change the block name** - Keep the same block name as the library block to maintain template compatibility
3. **Leverage parent methods** - Call `parent::method()` to build upon existing functionality
4. **Document customizations** - Add comments explaining what you've changed and why
5. **Test thoroughly** - Ensure your extensions work across different contexts and devices

## Next Steps

Explore the individual block pages to learn more about each block's specific features, use cases, and extension points.

