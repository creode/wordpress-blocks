---
title: render_blocks
editLink: false
---

# render_blocks

## Description

The `render_blocks()` method renders and sanitizes a content string of blocks or an array of block structures.

### Responsibility

This method handles the rendering of WordPress blocks, accepting either a string of block markup or an array of parsed block structures. It automatically sanitizes the output by removing script tags and line breaks, making it safe for display.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$content` | `string\|array` | Yes | Either a content string containing block markup, or an array of block structures |

### Return Value

- **Type**: `void`
- **Description**: Outputs the rendered and sanitized block content directly (does not return a value)

## Examples

### Rendering Block Markup String

```php
use Creode_Blocks\Helpers;

// Render blocks from a content string
$content = '<!-- wp:paragraph --><p>Hello World</p><!-- /wp:paragraph -->';
Helpers::render_blocks($content);
```

### Rendering Block Array

```php
use Creode_Blocks\Helpers;

// Render blocks from an array structure
$blocks = [
    [
        'blockName' => 'core/paragraph',
        'attrs' => [],
        'innerBlocks' => [],
        'innerHTML' => '<p>Hello World</p>',
        'innerContent' => ['<p>Hello World</p>']
    ]
];

Helpers::render_blocks($blocks);
```

### Rendering Inner Blocks

```php
use Creode_Blocks\Helpers;

// Within a block template file
// $block is available as WP_Block instance

if (!empty($block->parsed_block['innerBlocks'])) {
    Helpers::render_blocks($block->parsed_block['innerBlocks']);
}
```

### Rendering Custom Query Results

```php
use Creode_Blocks\Helpers;

// Get content from a custom post
$post = get_post(123);

if ($post) {
    Helpers::render_blocks($post->post_content);
}
```

