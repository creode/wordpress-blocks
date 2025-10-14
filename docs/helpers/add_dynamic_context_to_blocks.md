---
title: add_dynamic_context_to_blocks
editLink: false
---

# add_dynamic_context_to_blocks

## Description

The `add_dynamic_context_to_blocks()` method injects custom dynamic context data into an array of blocks and their nested inner blocks.

### Responsibility

This method modifies a block array by reference, adding a `dynamic_context` attribute to each block (including all nested inner blocks). This is a lower-level helper function primarily used internally by `render_blocks_with_dynamic_context()`, but can be called directly when you need to prepare blocks with context without immediately rendering them.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$blocks` | `array` (by reference) | Yes | An array of block structures to modify. Modified by reference using `&$blocks` |
| `$dynamic_context` | `array` | No | The dynamic context data to inject into blocks. Defaults to an empty array |

### Return Value

- **Type**: `void`
- **Description**: Modifies the `$blocks` array by reference, does not return a value

## Examples

### Preparing Blocks for Later Rendering

```php
use Creode_Blocks\Helpers;

// Parse blocks and add context before rendering
$blocks = parse_blocks($content);

$context = [
    'section' => 'header',
    'priority' => 'high'
];

// Add context to blocks (modifies $blocks array)
Helpers::add_dynamic_context_to_blocks($blocks, $context);

// Blocks now have dynamic_context attribute
// You can process them further or render them later
foreach ($blocks as $block) {
    // Each block now has attrs['dynamic_context']
    if (isset($block['attrs']['dynamic_context'])) {
        // Do something with the block
    }
}
```

### Building Custom Block Processors

```php
use Creode_Blocks\Helpers;

// Create a custom function that processes blocks with context
function process_blocks_with_metadata($blocks, $metadata) {
    // Add metadata as dynamic context
    Helpers::add_dynamic_context_to_blocks($blocks, $metadata);
    
    // Now perform custom processing
    foreach ($blocks as $block) {
        // Process each block knowing it has the metadata
        log_block_usage($block);
    }
    
    return $blocks;
}

$blocks = parse_blocks($content);
$metadata = ['source' => 'template', 'version' => '1.0'];
$processed_blocks = process_blocks_with_metadata($blocks, $metadata);
```

### Conditional Context Addition

```php
use Creode_Blocks\Helpers;

// Get the block instance to access fields
$block_instance = Helpers::get_block_by_name('your-block-name');

// Add different context based on conditions
$blocks = parse_blocks($block_instance->get_field('content_blocks'));

$context = [
    'timestamp' => time(),
    'cache_key' => md5($content)
];

// Only add context if certain conditions are met
if (is_user_logged_in()) {
    $context['user_id'] = get_current_user_id();
    $context['user_role'] = wp_get_current_user()->roles[0];
}

Helpers::add_dynamic_context_to_blocks($blocks, $context);

// Now render the blocks manually
foreach ($blocks as $block) {
    echo render_block($block);
}
```

### Nested Context Injection

```php
use Creode_Blocks\Helpers;

// Add context to blocks that will be embedded in other blocks
$inner_blocks = parse_blocks($inner_content);

$inner_context = [
    'level' => 'child',
    'parent_id' => $parent_block_id
];

Helpers::add_dynamic_context_to_blocks($inner_blocks, $inner_context);

// These blocks can now be inserted into a parent block structure
$parent_block['innerBlocks'] = $inner_blocks;
```

### Block Serialization with Context

```php
use Creode_Blocks\Helpers;

// Add context before serializing blocks for storage
$blocks = parse_blocks($content);

$context = [
    'modified_date' => current_time('mysql'),
    'modified_by' => get_current_user_id()
];

Helpers::add_dynamic_context_to_blocks($blocks, $context);

// Store the blocks with context for later retrieval
$serialized = serialize_blocks($blocks);
update_post_meta($post_id, 'processed_blocks', $serialized);
```

