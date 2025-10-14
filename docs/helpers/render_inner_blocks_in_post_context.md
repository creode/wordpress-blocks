---
title: render_inner_blocks_in_post_context
editLink: false
---

# render_inner_blocks_in_post_context

## Description

The `render_inner_blocks_in_post_context()` method renders the inner blocks of a WordPress block within the context of a specific post.

### Responsibility

This method extracts inner blocks from a `WP_Block` instance and renders them within the context of a specific post. It's a specialized helper that combines block structure inspection with post-contextual rendering. If the block has no inner blocks or no parsed block data, the method returns early without output.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$wp_block` | `WP_Block` | Yes | The block instance whose inner blocks should be rendered. This is available within render templates |
| `$post_id` | `int` | Yes | The ID of the post to use as context for rendering |

### Return Value

- **Type**: `void`
- **Description**: Outputs the rendered inner blocks directly, or returns early if no inner blocks exist

## Examples

### Basic Usage in a Block Template

```php
use Creode_Blocks\Helpers;

// Within a block template file (templates/block.php)
// $block is available as WP_Block instance
// Render inner blocks in the context of post 42

Helpers::render_inner_blocks_in_post_context($block, 42);
```

### Conditional Inner Block Rendering

```php
use Creode_Blocks\Helpers;

// Check if the block has inner content before rendering
if (!empty($block->parsed_block['innerBlocks'])) {
    $block_instance = \Creode_Blocks\Helpers::get_block_by_name('your-block-name');
    $context_post_id = $block_instance->get_field('related_post');
    
    if ($context_post_id) {
        // Render inner blocks with the related post's context
        Helpers::render_inner_blocks_in_post_context($block, $context_post_id);
    }
}
```

### Custom Container Block

```php
use Creode_Blocks\Helpers;

// In a container block template that displays content from another post
$block_instance = Helpers::get_block_by_name('your-block-name');
$featured_post_id = $block_instance->get_field('featured_post');

if ($featured_post_id) {
    echo '<div class="featured-content">';
    echo '<h2>' . get_the_title($featured_post_id) . '</h2>';
    
    // Render the container's inner blocks in the featured post's context
    Helpers::render_inner_blocks_in_post_context($block, $featured_post_id);
    
    echo '</div>';
}
```

### Post Listing with Inner Blocks

```php
use Creode_Blocks\Helpers;

// In a post listing block template
$block_instance = Helpers::get_block_by_name('post-listing');
$posts = $block_instance->get_field('posts_to_display');

foreach ($posts as $post_id) {
    echo '<article class="post-item">';
    
    // Render the same inner block template for each post
    // but with different post context
    Helpers::render_inner_blocks_in_post_context($block, $post_id);
    
    echo '</article>';
}
```

