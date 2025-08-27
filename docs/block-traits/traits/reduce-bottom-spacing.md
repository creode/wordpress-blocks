---
title: Reduce Bottom Space Trait
editLink: false
---

# Reduce Bottom Space Trait

The `Trait_Has_Reduce_Bottom_Space_Option` adds a "Reduce Bottom Space" setting to blocks, allowing content editors to control the spacing between blocks when there's no clear visual boundary.

## Purpose

This trait is designed to:
- Provide editors with control over block spacing
- Improve visual hierarchy between adjacent blocks
- Add a standardized spacing control option
- Integrate seamlessly with the modifier classes system
- Work automatically with the default template wrapper

## Dependencies

**Important:** This trait **requires** `Trait_Has_Modifier_Classes` to function properly. However, since `Trait_Has_Modifier_Classes` is automatically included in the `Block` abstract class by default, you typically don't need to worry about this dependency.

The trait will throw an exception if used without `Trait_Has_Modifier_Classes`, but this should never happen when extending the `Block` class normally.

## How It Works

The trait automatically:
1. Adds a "Reduce Bottom Space" ACF field to the block
2. Integrates with the modifier classes system
3. Applies the `reduce-bottom-space` modifier class when enabled
4. Handles all initialization automatically
5. Works seamlessly with the default template wrapper

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    // Trait_Has_Modifier_Classes is automatically included
    use Trait_Has_Reduce_Bottom_Space_Option;
    
    // ... rest of block implementation
}
```

### Required Setup

Since this trait depends on `Trait_Has_Modifier_Classes` (which is automatically included), you must implement the required method:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    // Modifier Classes trait is automatically included
    use Trait_Has_Reduce_Bottom_Space_Option;
    
    /**
     * Returns an array of single terms (no prefix) to be converted to modifier classes.
     */
    protected function modifier_classes(): array {
        return array(
            'primary',
            'secondary',
            // The reduce-bottom-space class will be added automatically when needed
        );
    }
}
```

### Automatic Integration

When using the default template wrapper, this trait works automatically:

```php
<?php
use Creode_Blocks\Block;

class Simple_Block extends Block {
    use Trait_Has_Reduce_Bottom_Space_Option;
    
    protected function modifier_classes(): array {
        return array(
            'featured',
            'highlighted',
        );
    }
    
    // Uses default template wrapper automatically
    // Reduce bottom space functionality works without any template code
}
?>
```

## Auto-Initialization

This trait automatically initializes when added to a block class. The initialization process:

1. **Dependency Check** - Verifies `Trait_Has_Modifier_Classes` is present (automatically satisfied)
2. **Field Addition** - Adds the "Reduce Bottom Space" ACF field
3. **Modifier Integration** - Connects with the modifier classes system
4. **Default Wrapper Integration** - Works automatically with the default template system

## Added ACF Field

The trait automatically adds the following ACF field:

| Property | Value |
|----------|-------|
| **Key** | `field_{block_name}_reduce_bottom_space` |
| **Name** | `reduce_bottom_space` |
| **Label** | `Bottom Space` |
| **Message** | `Reduce Bottom Space` |
| **Instructions** | `Useful when there is no clear boundary between an adjacent block.` |
| **Type** | `true_false` |

## Generated Modifier Class

When the "Reduce Bottom Space" option is enabled, the trait automatically adds the `reduce-bottom-space` modifier class to your block's modifier classes.

## CSS Integration

### Basic CSS Structure

```scss
.my-block__wrapper {
    // Base styles with normal bottom margin
    margin-bottom: 2rem;
    
    &--reduce-bottom-space {
        // Reduced bottom margin when the option is enabled
        margin-bottom: 1rem;
    }
}
```

### Advanced CSS Examples

```scss
.my-block__wrapper {
    margin-bottom: 2rem;
    
    &--reduce-bottom-space {
        margin-bottom: 0.5rem;
        
        // You can also adjust other spacing properties
        padding-bottom: 1rem;
        
        // Or use negative margins for tighter spacing
        margin-bottom: -0.5rem;
    }
}
```

### Responsive Spacing

```scss
.my-block__wrapper {
    margin-bottom: 2rem;
    
    @media (max-width: 768px) {
        margin-bottom: 1.5rem;
    }
    
    &--reduce-bottom-space {
        margin-bottom: 1rem;
        
        @media (max-width: 768px) {
            margin-bottom: 0.75rem;
        }
    }
}
```

## Use Cases

### Content Blocks

```php
<?php
class Content_Block extends Block {
    // Modifier Classes trait automatically included
    use Trait_Has_Reduce_Bottom_Space_Option;
    
    protected function modifier_classes(): array {
        return array(
            'left',
            'center',
            'right',
        );
    }
}
?>
```

### Hero Sections

```php
<?php
class Hero_Block extends Block {
    // Modifier Classes trait automatically included
    use Trait_Has_Reduce_Bottom_Space_Option;
    
    protected function modifier_classes(): array {
        return array(
            'full-height',
            'dark',
            'centered',
        );
    }
}
?>
```

### Call-to-Action Blocks

```php
<?php
class Call_To_Action_Block extends Block {
    // Modifier Classes trait automatically included
    use Trait_Has_Reduce_Bottom_Space_Option;
    
    protected function modifier_classes(): array {
        return array(
            'primary',
            'secondary',
            'outlined',
        );
    }
}
?>
```

## Template Usage

### With Default Wrapper (Automatic)

The trait works automatically with the default template wrapper - no additional template code is needed. The modifier class will be applied through the existing `get_modifier_class_string()` method automatically.

### With Custom Templates

If you're using a custom template, you can manually access the modifier classes:

```php
<?php
// Only needed in custom templates, not with default wrapper
$modifier_classes = $this->get_modifier_class_string( 'my-block__wrapper' );
?>

<div class="<?php echo esc_attr( $modifier_classes ); ?>">
    <!-- Block content -->
</div>
```

## Error Handling

If you attempt to use this trait without `Trait_Has_Modifier_Classes`, you'll receive a clear exception message:

```
Exception: Creode_Blocks\Trait_Has_Reduce_Bottom_Space_Option should only ever be used alongside Creode_Blocks\Trait_Has_Modifier_Classes. Please add this trait to [Your_Class_Name] and conform to its requirements.
```

**Note:** This error should never occur when extending the `Block` class normally, as `Trait_Has_Modifier_Classes` is automatically included.

## Best Practices

1. **Use with default wrapper** - Let the system handle modifier classes automatically
2. **Plan your CSS** - Design your CSS to handle the `reduce-bottom-space` modifier
3. **Consider context** - Use this option when blocks need tighter visual grouping
4. **Test spacing** - Verify that reduced spacing works well in your design
5. **Document usage** - Let content editors know when to use this option
6. **Leverage automatic integration** - No need to manually handle modifier classes

## Common Scenarios

- **Tight content grouping** - When multiple related blocks should appear as a unit
- **Visual hierarchy** - When you want to emphasize the relationship between blocks
- **Layout optimization** - When standard spacing creates too much visual separation
- **Mobile considerations** - When you need tighter spacing on smaller screens
