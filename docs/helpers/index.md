---
title: Helpers
editLink: false
---

# Helpers

## Overview

The `Creode_Blocks\Helpers` class provides a collection of static utility functions designed to simplify common tasks when working with WordPress blocks. These helper methods handle block retrieval, rendering, context management, and configuration.

## Usage

The helper functions can be used **anywhere within your theme or plugin** where you need to work with blocks programmatically. Simply import the class and call the static methods:

```php
use Creode_Blocks\Helpers;

// Use any helper method
Helpers::render_blocks($content);
```

## Particularly Useful in Block Templates

While these helpers are available globally, they are **particularly useful within block template files** (`templates/block.php`). Block templates often need to:

- Render inner blocks with specific context
- Access block instances
- Manipulate block structures dynamically
- Apply custom context to nested blocks

### Example in a Block Template

```php
<?php
/**
 * Block template file: templates/block.php
 * 
 * @var WP_Block $block The block instance
 * @var array $attributes The block attributes
 */

use Creode_Blocks\Helpers;

// Get the block instance to access fields
$block_instance = Helpers::get_block_by_name('my-block');

// Get a related post ID from block fields
$related_post_id = $block_instance->get_field('related_post');

?>

<div class="my-block">
    <h2><?php echo esc_html($attributes['title']); ?></h2>
    
    <?php if ($related_post_id): ?>
        <div class="related-content">
            <?php 
            // Render inner blocks in the context of the related post
            Helpers::render_inner_blocks_in_post_context($block, $related_post_id);
            ?>
        </div>
    <?php endif; ?>
</div>
```

## Available Helper Functions

The Helpers class provides functions organized into several categories:

### Block Management
- **get_block_by_name** - Retrieve a block instance by its name

### Block Rendering
- **render_blocks** - Render blocks from a string or array
- **render_blocks_in_post_context** - Render blocks within a specific post's context
- **render_inner_blocks_in_post_context** - Render a block's inner blocks with post context

### Dynamic Context
- **render_blocks_with_dynamic_context** - Render blocks with custom context data
- **add_dynamic_context_to_blocks** - Inject context into block structures

### Configuration
- **set_default_block_category** - Set the default category for new blocks
- **set_acf_block_mode** - Configure ACF block display modes

## When to Use Helpers

Consider using these helpers when you need to:

- **Render blocks dynamically** outside of the standard WordPress content flow
- **Provide post-specific context** to blocks that wouldn't normally have it
- **Pass custom data** down through nested block structures
- **Build complex block interactions** that require accessing other block instances
- **Configure block behavior** programmatically based on conditions

## Next Steps

Explore the individual helper function pages to learn more about each method's parameters, return values, and practical examples.

