---
title: Modifier Classes Trait
editLink: false
---

# Modifier Classes Trait

The `Trait_Has_Modifier_Classes` provides a systematic way to manage CSS modifier classes for blocks, allowing for flexible styling variations based on block configuration or user selections.

## Important Notes

**This trait is automatically included in the `Creode_Blocks\Block` abstract class by default.** You do not need to explicitly add it to your block classes unless you want to override its behavior.

**Important:** The automatic calling of `get_modifier_class_string()` only happens when the `use_default_wrapper_template()` method returns `true`. When this method returns `true`, the contents of your template file are automatically enclosed within the default block wrapper template, which calls `get_modifier_class_string()` automatically.

**All blocks must always provide a `template()` function that returns a valid path to a template file.** The `use_default_wrapper_template()` method only determines whether your template content is wrapped in the default wrapper.

## Purpose

This trait is designed to:
- Generate consistent CSS modifier class names
- Allow blocks to have multiple visual variations
- Provide a standardized approach to CSS class management
- Enable dynamic class generation based on block fields
- Automatically integrate with the default block wrapper system when enabled

## How It Works

The trait follows a BEM (Block Element Modifier) naming convention and automatically generates modifier classes by appending them to a base class. It integrates with WordPress filters to allow dynamic modification of classes.

**Automatic Integration:** When `use_default_wrapper_template()` returns `true`, modifier classes are automatically applied to the block's wrapper element through the default wrapper template.

**Manual Integration:** When `use_default_wrapper_template()` returns `false`, you must manually call `get_modifier_class_string()` in your template files.

## Usage

### Automatic Integration (Default Wrapper Enabled)

When `use_default_wrapper_template()` returns `true` (the default behavior):

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    /**
     * Returns an array of single terms (no prefix) to be converted to modifier classes.
     * No need to use Trait_Has_Modifier_Classes - it's included by default.
     */
    protected function modifier_classes(): array {
        return array(
            'primary',
            'secondary',
            'large',
            'small',
        );
    }
    
    /**
     * Always required - returns the path to your template file.
     */
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    /**
     * Returns true to use the default wrapper (enables automatic modifier class integration).
     */
    protected function use_default_wrapper_template(): bool {
        return true; // This is the default behavior
    }
}
?>
```

**What happens:**
1. Your template file (`block.php`) contains only the block content
2. The default wrapper automatically encloses your content
3. Modifier classes are automatically applied to the wrapper
4. No manual template code needed for modifier classes

### Manual Integration (Default Wrapper Disabled)

When `use_default_wrapper_template()` returns `false`:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    protected function modifier_classes(): array {
        return array(
            'primary',
            'secondary',
            'large',
            'small',
        );
    }
    
    /**
     * Always required - returns the path to your template file.
     */
    protected function template(): string {
        return __DIR__ . '/templates/custom-block.php';
    }
    
    /**
     * Returns false to disable the default wrapper (requires manual modifier class handling).
     */
    protected function use_default_wrapper_template(): bool {
        return false;
    }
}
?>
```

**What happens:**
1. Your template file (`custom-block.php`) must handle the complete block structure
2. You must manually call `get_modifier_class_string()` in your template
3. You have full control over the HTML structure

### In Custom Templates (When Default Wrapper is Disabled)

Only use this when `use_default_wrapper_template()` returns `false`:

```php
<?php
// Only needed when default wrapper is disabled
$modifier_classes = $this->get_modifier_class_string( 'my-block__wrapper' );
?>

<div class="<?php echo esc_attr( $modifier_classes ); ?>">
    <!-- Block content -->
</div>
```

## Generated Class Format

The trait generates classes in the following format:
```
{base-class}--{modifier-class}
```

For example, with base class `my-block__wrapper`:
- `my-block__wrapper--primary`
- `my-block__wrapper--secondary`
- `my-block__wrapper--large`
- `my-block__wrapper--small`

## Available Methods

### `get_modifier_class_string( string $base_class = 'example-block__wrapper' )`

Returns a string of additional classes to be added to block wrappers.

**Parameters:**
- `$base_class` (string) - The base class that modifiers should be appended to. Defaults to `'example-block__wrapper'`.

**Returns:** `string` - A space-separated string of modifier classes

**Note:** This method is automatically called by the default wrapper template when `use_default_wrapper_template()` returns `true`. You only need to call it manually when the default wrapper is disabled.

**Example:**
```php
$classes = $this->get_modifier_class_string( 'my-block__wrapper' );
// Returns: "my-block__wrapper--primary my-block__wrapper--secondary"
```

### `modifier_classes()`

Protected method that returns an array of single terms (no prefix) to be converted to modifier classes.

**Returns:** `array` - An array of modifier terms

**Example:**
```php
protected function modifier_classes(): array {
    return array(
        'primary',
        'secondary',
        'large',
        'small',
    );
}
```

## Default Template Wrapper Integration

When `use_default_wrapper_template()` returns `true`, the system automatically:

1. **Uses the default wrapper template** - Your template content is enclosed in the default structure
2. **Automatic Method Call** - `get_modifier_class_string()` is called automatically by the wrapper
3. **Wrapper Integration** - Classes are applied to the block's wrapper element
4. **Seamless Operation** - Modifier classes work out of the box

### Example with Default Wrapper

```php
<?php
use Creode_Blocks\Block;

class Simple_Block extends Block {
    // No need to use Trait_Has_Modifier_Classes - it's included by default
    
    protected function modifier_classes(): array {
        return array(
            'featured',
            'highlighted',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    // use_default_wrapper_template() returns true by default
    // Modifier classes are applied automatically
}
?>
```

**Template file (`templates/block.php`):**
```php
<h2>Block Title</h2>
<p>Block content goes here.</p>
```

**Resulting HTML (automatically generated):**
```html
<div class="simple-block__outer-wrapper">
    <div class="simple-block__wrapper simple-block__wrapper--featured">
        <div class="simple-block__inner">
            <h2>Block Title</h2>
            <p>Block content goes here.</p>
        </div>
    </div>
</div>
```

## When to Use Manual Integration

You only need to manually integrate this trait when:

1. **Default wrapper disabled** - `use_default_wrapper_template()` returns `false`
2. **Custom HTML structure** - Need complete control over the block's HTML
3. **Override behavior** - Want to change how modifier classes are generated
4. **Custom logic** - Need custom modifier class logic beyond the standard implementation
5. **Multiple wrapper elements** - Need modifier classes on multiple elements

## Dynamic Class Modification

The trait integrates with WordPress filters to allow dynamic modification of classes:

### Filter Hook: `block-{block-name}-modifier-classes`

This filter allows you to modify the modifier classes at runtime:

```php
<?php
// Add a filter to modify classes for a specific block
add_filter( 'block-my-block-modifier-classes', function( $classes ) {
    // Add conditional classes based on some logic
    if ( is_front_page() ) {
        $classes[] = 'homepage';
    }
    
    return $classes;
});
?>
```

## Use Cases

### Basic Modifier Classes (Default Wrapper Enabled)

```php
<?php
class Content_Block extends Block {
    // Trait automatically included, default wrapper enabled
    
    protected function modifier_classes(): array {
        return array(
            'left',
            'center',
            'right',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    // use_default_wrapper_template() returns true by default
    // No template changes needed - modifier classes work automatically
}
?>
```

### Field-Based Modifiers (Default Wrapper Enabled)

```php
<?php
class Hero_Block extends Block {
    // Trait automatically included, default wrapper enabled
    
    protected function modifier_classes(): array {
        $classes = array();
        
        // Add classes based on ACF fields
        if ( $this->get_field( 'full_height' ) ) {
            $classes[] = 'full-height';
        }
        
        if ( $this->get_field( 'dark_theme' ) ) {
            $classes[] = 'dark';
        }
        
        return $classes;
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    // Modifier classes automatically reflect field values
}
?>
```

### Conditional Modifiers (Default Wrapper Enabled)

```php
<?php
class Call_To_Action_Block extends Block {
    // Trait automatically included, default wrapper enabled
    
    protected function modifier_classes(): array {
        $classes = array();
        
        // Add classes based on context
        if ( is_page_template( 'landing-page.php' ) ) {
            $classes[] = 'landing-page';
        }
        
        // Add classes based on user role
        if ( current_user_can( 'manage_options' ) ) {
            $classes[] = 'admin';
        }
        
        return $classes;
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    // Context-aware modifier classes applied automatically
}
?>
```

## CSS Integration

### Basic CSS Structure

```scss
.my-block__wrapper {
    // Base styles
    
    &--primary {
        background-color: #007cba;
        color: white;
    }
    
    &--secondary {
        background-color: #f0f0f0;
        color: #333;
    }
    
    &--large {
        padding: 2rem;
        font-size: 1.2rem;
    }
    
    &--small {
        padding: 0.5rem;
        font-size: 0.9rem;
    }
}
```

### Responsive Modifiers

```scss
.my-block__wrapper {
    &--mobile-only {
        @media (min-width: 768px) {
            display: none;
        }
    }
    
    &--desktop-only {
        @media (max-width: 767px) {
            display: none;
        }
    }
}
```

## Dependencies

This trait has no dependencies and can be used independently. However, it's automatically included in the `Block` abstract class, so you typically don't need to add it manually.

## Best Practices

1. **Use the default wrapper when possible** - Let the system handle modifier classes automatically
2. **Always provide a template function** - Every block must return a valid template path
3. **Override modifier_classes()** - Define your modifier classes in the method
4. **Keep modifiers focused** - Each modifier should represent a single concept
5. **Follow BEM conventions** - Use the established naming pattern for consistency
6. **Consider CSS specificity** - Ensure your CSS selectors have appropriate specificity
7. **Document your modifiers** - Keep a clear list of available modifiers for developers
8. **Test automatic integration** - Verify modifier classes work with the default wrapper
9. **Understand when manual integration is needed** - Only when `use_default_wrapper_template()` returns `false`

## Common Modifier Patterns

- **Size variations:** `small`, `medium`, `large`
- **Color themes:** `primary`, `secondary`, `accent`
- **Layout options:** `left`, `center`, `right`, `full-width`
- **Visual styles:** `outlined`, `filled`, `minimal`
- **Context variations:** `homepage`, `archive`, `single`
