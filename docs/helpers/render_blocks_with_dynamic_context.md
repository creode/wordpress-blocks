---
title: render_blocks_with_dynamic_context
editLink: false
---

# render_blocks_with_dynamic_context

## Description

The `render_blocks_with_dynamic_context()` method renders an array of blocks with custom dynamic context data injected into each block and its nested inner blocks.

### Responsibility

This method adds a `dynamic_context` attribute to all blocks in the provided array (including nested blocks) and then renders them. This allows you to pass custom data down through a block tree, making it accessible to all blocks during rendering via their attributes.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$blocks` | `array` | Yes | An array of block structures to render |
| `$dynamic_context` | `array` | No | The dynamic context data to inject into blocks. Defaults to an empty array |

### Return Value

- **Type**: `void`
- **Description**: Outputs the rendered blocks with injected dynamic context (does not return a value)

## Examples

### Passing Custom Data to Blocks

```php
use Creode_Blocks\Helpers;

// Render blocks with custom context data
$blocks = parse_blocks($content);

$context = [
    'user_id' => get_current_user_id(),
    'is_preview' => true,
    'theme' => 'dark'
];

Helpers::render_blocks_with_dynamic_context($blocks, $context);
```

### Accessing Dynamic Context in Block Template

```php
// In your block template file (templates/block.php)
// Access the dynamic context from block attributes

$dynamic_context = $block->context['dynamic_context'] ?? [];

if (isset($dynamic_context['theme'])) {
    $theme_class = 'theme-' . $dynamic_context['theme'];
    echo '<div class="' . esc_attr($theme_class) . '">';
}

// Rest of your template...
```

### Filtering Content by Context

```php
use Creode_Blocks\Helpers;

// Pass filtering criteria through dynamic context
$category_id = 5;
$blocks = parse_blocks(get_field('content_template'));

$context = [
    'filter' => [
        'category' => $category_id,
        'post_type' => 'product',
        'posts_per_page' => 10
    ]
];

Helpers::render_blocks_with_dynamic_context($blocks, $context);
```

### Preview Mode Context

```php
use Creode_Blocks\Helpers;

// Indicate preview mode to blocks
$is_admin = is_admin();
$blocks = get_field('reusable_content');

$context = [
    'preview_mode' => $is_admin,
    'edit_link' => $is_admin ? admin_url('post.php?post=' . $post->ID . '&action=edit') : null
];

Helpers::render_blocks_with_dynamic_context($blocks, $context);
```

### Multi-Language Context

```php
use Creode_Blocks\Helpers;

// Pass language information through context
$current_language = apply_filters('wpml_current_language', null);
$blocks = parse_blocks($template_content);

$context = [
    'language' => $current_language,
    'is_default_language' => $current_language === 'en',
    'translations' => [
        'read_more' => __('Read More', 'textdomain'),
        'learn_more' => __('Learn More', 'textdomain')
    ]
];

Helpers::render_blocks_with_dynamic_context($blocks, $context);
```

