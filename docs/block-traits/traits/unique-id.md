---
title: Unique ID Trait
editLink: false
---

# Unique ID Trait

The `Trait_Has_Unique_Id` provides a mechanism for generating unique identifiers for blocks, ensuring that each block instance has a distinct identifier during rendering.

## Purpose

This trait is essential when you need to:
- Generate unique CSS IDs for styling
- Create unique JavaScript selectors
- Ensure accessibility compliance with unique IDs
- Avoid conflicts when multiple instances of the same block exist on a page

## How It Works

The trait maintains an internal counter for each block type and generates sequential identifiers. Each call to `get_unique_id()` returns a unique string that will never repeat within a single WordPress execution.

**Note:** This functionality is only applicable to front-end output because editors use multiple WordPress executions.

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Has_Unique_Id;
    
    // ... rest of block implementation
}
```

### In Templates

```php
<?php
// Generate a unique ID for this block instance
$unique_id = $this->get_unique_id();
?>

<div id="<?php echo esc_attr( $unique_id ); ?>" class="my-block">
    <!-- Block content -->
</div>
```

### With CSS Classes

```php
<?php
$unique_id = $this->get_unique_id();
?>

<div id="<?php echo esc_attr( $unique_id ); ?>" 
     class="my-block my-block--<?php echo esc_attr( $unique_id ); ?>">
    <!-- Block content -->
</div>
```

## Generated ID Format

The trait generates IDs in the following format:
```
{block-name}-{sequential-number}
```

For example:
- `my-block-0`
- `my-block-1`
- `my-block-2`

## Available Methods

### `get_unique_id()`

Returns a unique ID string for the current block instance.

**Returns:** `string` - A unique identifier

**Example:**
```php
$id = $this->get_unique_id(); // Returns: "my-block-0"
```

## Internal Implementation

The trait uses WordPress filters to maintain state:

1. **Filter Hook:** `{block_name}_iterator`
2. **Default Value:** `0`
3. **Increment:** Each call adds 1 to the counter

## Use Cases

### CSS Styling
```php
<?php
$unique_id = $this->get_unique_id();
?>

<style>
#<?php echo esc_attr( $unique_id ); ?> {
    /* Block-specific styles */
}
</style>
```

### JavaScript Integration
```php
<?php
$unique_id = $this->get_unique_id();
?>

<script>
document.getElementById('<?php echo esc_js( $unique_id ); ?>')
    .addEventListener('click', function() {
        // Block-specific JavaScript
    });
</script>
```

### Accessibility
```php
<?php
$unique_id = $this->get_unique_id();
?>

<div id="<?php echo esc_attr( $unique_id ); ?>" 
     role="region" 
     aria-labelledby="<?php echo esc_attr( $unique_id ); ?>-title">
    <h2 id="<?php echo esc_attr( $unique_id ); ?>-title">Block Title</h2>
    <!-- Block content -->
</div>
```

## Dependencies

This trait has no dependencies and can be used independently.

## Performance Considerations

- The trait uses WordPress filters which have minimal performance impact
- IDs are generated on-demand, not pre-computed
- No database queries or heavy operations are performed

## Best Practices

1. **Use for unique identification** - Only use when you need truly unique identifiers
2. **Escape output** - Always use `esc_attr()` or `esc_js()` when outputting IDs
3. **Consider context** - Remember this only works on the front-end
4. **Plan for multiple instances** - Design your CSS and JavaScript to handle multiple block instances
