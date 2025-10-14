---
title: get_block_by_name
editLink: false
---

# get_block_by_name

## Description

The `get_block_by_name()` method retrieves a single block instance by its registered block name.

### Responsibility

This method searches through all registered block instances and returns the first block that matches the provided name. It provides a way to programmatically access block instances that have been registered with the WordPress Blocks plugin.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$name` | `string` | Yes | The block name to search for (e.g., 'your-first-block') |

### Return Value

- **Type**: `Block|null`
- **Description**: Returns the matching Block instance if found, or `null` if no block with the given name exists

## Examples

### Basic Usage

```php
use Creode_Blocks\Helpers;

// Get a block instance by name
$block = Helpers::get_block_by_name('your-first-block');

if ($block !== null) {
    // Block was found, you can now use it
    echo $block->get_label();
}
```

### Checking Block Existence

```php
use Creode_Blocks\Helpers;

// Check if a specific block is registered
$header_block = Helpers::get_block_by_name('site-header');

if ($header_block === null) {
    // Block doesn't exist, handle gracefully
    error_log('Site header block is not registered');
    return;
}

// Proceed with block operations
```

### Accessing Block Properties

```php
use Creode_Blocks\Helpers;

$block = Helpers::get_block_by_name('post-listing');

if ($block) {
    // Access block information
    $name = $block->get_name();
    $label = $block->get_label();
    
    echo "Found block: {$label} ({$name})";
}
```

