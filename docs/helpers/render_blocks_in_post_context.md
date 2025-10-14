---
title: render_blocks_in_post_context
editLink: false
---

# render_blocks_in_post_context

## Description

The `render_blocks_in_post_context()` method renders blocks within the context of a specific post, making post data available to the blocks being rendered.

### Responsibility

This method temporarily sets up the WordPress global `$post` variable and post data for a specific post ID, renders the provided blocks within that context, and then resets the post data. This is particularly useful when rendering blocks that depend on post-specific template tags or data. The method also supports WPML translation by applying the `wpml_object_id` filter.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$content` | `string\|array` | Yes | Either a content string containing block markup, or an array of block structures |
| `$post_id` | `int` | Yes | The ID of the post to use as context for rendering |

### Return Value

- **Type**: `void`
- **Description**: Outputs the rendered and sanitized block content directly (does not return a value)

## Examples

### Rendering Blocks from Another Post

```php
use Creode_Blocks\Helpers;

// Render blocks from post ID 42 in its context
$post_id = 42;
$blocks = parse_blocks(get_post($post_id)->post_content);

Helpers::render_blocks_in_post_context($blocks, $post_id);
```

### Building a Custom Post Listing

```php
use Creode_Blocks\Helpers;

// Query posts and render each with their own content
$posts = get_posts([
    'post_type' => 'article',
    'posts_per_page' => 5
]);

foreach ($posts as $post) {
    echo '<article>';
    // Render the post's blocks in its own context
    // This ensures template tags like the_title() work correctly
    Helpers::render_blocks_in_post_context($post->post_content, $post->ID);
    echo '</article>';
}
```

### Rendering Template Parts with Post Context

```php
use Creode_Blocks\Helpers;

// Get a reusable block and render it in a specific post's context
$template_post_id = 123;
$context_post_id = 456;

$template_content = get_post($template_post_id)->post_content;

// Render the template with context from a different post
Helpers::render_blocks_in_post_context($template_content, $context_post_id);
```

### WPML Integration

```php
use Creode_Blocks\Helpers;

// The method automatically handles WPML translations
// If WPML is active, it will get the translated version of the post

$original_post_id = 100;
$blocks = get_post_field('post_content', $original_post_id);

// This will use the translated post ID if WPML is active
Helpers::render_blocks_in_post_context($blocks, $original_post_id);
```

