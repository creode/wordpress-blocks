---
title: CSS Variables Trait
editLink: false
---

# CSS Variables Trait

The `Trait_Has_CSS_Variables` provides blocks with the ability to supply CSS variables within the context of the block markup, enabling dynamic styling based on block configuration or user selections.

## Purpose

This trait is designed to:
- Allow blocks to provide CSS variables for dynamic styling
- Enable theme-consistent color and styling integration
- Support responsive and conditional styling through CSS variables
- Integrate seamlessly with the default template wrapper system
- Work automatically with blocks using the default wrapper template

## Important Notes

**This trait is automatically included in the `Creode_Blocks\Block` abstract class by default.** You do not need to explicitly add it to your block classes unless you want to override its behavior.

**Important:** The automatic calling of `get_css_variable_string()` only happens when the `use_default_wrapper_template()` method returns `true`. When this method returns `true`, the contents of your template file are automatically enclosed within the default block wrapper template, which calls `get_css_variable_string()` automatically.

**All blocks must always provide a `template()` function that returns a valid path to a template file.** The `use_default_wrapper_template()` method only determines whether your template content is wrapped in the default wrapper.

## How It Works

The trait automatically:
1. Provides a method to define CSS variables for blocks
2. Generates properly formatted CSS variable strings
3. Integrates with the default template wrapper system
4. Applies CSS variables to the block's wrapper element automatically
5. Works seamlessly with other traits like `Trait_Has_Color_Choices`

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    // Trait_Has_CSS_Variables is automatically included
    
    /**
     * Returns a keyed array of CSS variables.
     * Where the key is the CSS variable name and the value is the CSS variable value.
     */
    protected function css_variables(): array {
        return array(
            'my-block-primary-color' => '#007cba',
            'my-block-spacing' => '2rem',
            'my-block-border-radius' => '8px',
        );
    }
    
    // ... rest of block implementation
}
```

### Automatic Integration (Default Wrapper Enabled)

When `use_default_wrapper_template()` returns `true` (the default behavior):

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    // CSS Variables trait is automatically included
    
    protected function css_variables(): array {
        return array(
            'my-block-primary-color' => '#007cba',
            'my-block-secondary-color' => '#f0f0f0',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    // use_default_wrapper_template() returns true by default
    // CSS variables are applied automatically
}
```

**What happens:**
1. Your template file (`block.php`) contains only the block content
2. The default wrapper automatically encloses your content
3. CSS variables are automatically applied to the wrapper's style attribute
4. No manual template code needed for CSS variables

### Manual Integration (Default Wrapper Disabled)

When `use_default_wrapper_template()` returns `false`:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    protected function css_variables(): array {
        return array(
            'my-block-primary-color' => '#007cba',
            'my-block-spacing' => '2rem',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/custom-block.php';
    }
    
    protected function use_default_wrapper_template(): bool {
        return false;
    }
}
```

**What happens:**
1. Your template file (`custom-block.php`) must handle the complete block structure
2. You must manually call `get_css_variable_string()` in your template
3. You have full control over where CSS variables are applied

### In Custom Templates (When Default Wrapper is Disabled)

Only use this when `use_default_wrapper_template()` returns `false`:

```php
<?php
// Only needed when default wrapper is disabled
$block = Creode_Blocks\Helpers::get_block_by_name( 'my-block' );
$css_variables = $block->get_css_variable_string();
?>

<div class="my-block__wrapper" style="<?php echo esc_attr( $css_variables ); ?>">
    <!-- Block content -->
</div>
```

## Generated CSS Variable Format

The trait generates CSS variables in the following format:
```css
--{variable-name}: {variable-value};
```

For example, with the variables:
```php
array(
    'my-block-primary-color' => '#007cba',
    'my-block-spacing' => '2rem',
)
```

Results in:
```css
--my-block-primary-color: #007cba; --my-block-spacing: 2rem;
```

## Available Methods

### `css_variables()`

Protected method that returns a keyed array of CSS variables.

**Returns:** `array` - Keyed array where keys are CSS variable names and values are CSS variable values

**Example:**
```php
protected function css_variables(): array {
    return array(
        'my-block-primary-color' => '#007cba',
        'my-block-spacing' => '2rem',
        'my-block-border-radius' => '8px',
    );
}
```

### `get_css_variable_string()`

Returns a string of CSS variables to be used by a block wrapper's style attribute.

**Returns:** `string` - A space-separated string of CSS variables

**Note:** This method is automatically called by the default wrapper template when `use_default_wrapper_template()` returns `true`. You only need to call it manually when the default wrapper is disabled.

**Example:**
```php
$css_vars = $this->get_css_variable_string();
// Returns: " --my-block-primary-color: #007cba; --my-block-spacing: 2rem; "
```

## Integration with Color Choices Trait

The CSS Variables trait works seamlessly with `Trait_Has_Color_Choices` to provide dynamic color theming:

### Example: Decoration Color Block

```php
<?php
use Creode_Blocks\Block;

class Decoration_Block extends Block {
    use Trait_Has_Color_Choices;
    // Trait_Has_CSS_Variables is automatically included
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_decoration_block_color',
                'name'  => 'decoration_color',
                'label' => 'Decoration Color',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
        );
    }
    
    protected function css_variables(): array {
        $decoration_color = $this->get_field( 'decoration_color' );
        $variables = array();
        
        if ( ! empty( $decoration_color ) ) {
            $color_code = $this->get_color_code_by_slug( $decoration_color );
            if ( ! empty( $color_code ) ) {
                $variables['decoration-color'] = $color_code;
            }
        }
        
        return $variables;
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    // CSS variables are applied automatically via default wrapper
}
?>
```

**Template file (`templates/block.php`):**
```php
<div class="decoration-block__content">
    <h2>Block Title</h2>
    <p>This block uses CSS variables for dynamic decoration color.</p>
</div>
```

**Resulting HTML (automatically generated):**
```html
<div class="decoration-block__outer-wrapper">
    <div class="decoration-block__wrapper" style=" --decoration-color: #007cba; ">
        <div class="decoration-block__inner">
            <div class="decoration-block__content">
                <h2>Block Title</h2>
                <p>This block uses CSS variables for dynamic decoration color.</p>
            </div>
        </div>
    </div>
</div>
```

**CSS to respond to the variable:**
```scss
.decoration-block__wrapper {
    // Use the CSS variable for decoration elements
    &::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background-color: var(--decoration-color, #ccc);
    }
    
    // Or apply to child elements
    .decoration-block__content {
        border-left: 3px solid var(--decoration-color, #ccc);
        padding-left: 1rem;
    }
}
```

## CSS Integration

### Basic CSS Variable Usage

```scss
.my-block__wrapper {
    // Use CSS variables with fallbacks
    padding: var(--block-padding, 1rem);
    border-radius: var(--border-radius, 4px);
    box-shadow: var(--shadow, none);
    
    // Apply decoration color
    &::before {
        background-color: var(--decoration-color, #ccc);
    }
}
```

## Error Handling

The trait gracefully handles various scenarios:

- **Empty variables array:** Returns empty string for CSS variables
- **Invalid variable values:** Includes variables as-is (CSS will handle validation)
- **Missing field values:** Skips variables for empty fields
- **Template integration failure:** Continues execution without breaking

## Best Practices

1. **Use semantic variable names** - Choose clear, descriptive CSS variable names
2. **Provide fallback values** - Always include fallback values in your CSS
3. **Keep variables focused** - Each variable should represent a single concept
4. **Use the default wrapper when possible** - Let the system handle CSS variable application automatically
5. **Test variable output** - Verify CSS variables are applied correctly
6. **Consider performance** - Don't create unnecessary CSS variables
7. **Document your variables** - Keep a clear list of available CSS variables for developers
8. **Leverage automatic integration** - No need to manually handle CSS variables with default wrapper
9. **Understand when manual integration is needed** - Only when `use_default_wrapper_template()` returns `false`

## Dependencies

This trait has no dependencies and can be used independently. However, it's automatically included in the `Block` abstract class, so you typically don't need to add it manually.
