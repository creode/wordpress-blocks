---
title: Traits Overview
editLink: false
---

# Block Traits Overview

This document provides a comprehensive overview of how all the available traits work together to create powerful, flexible blocks.

## Trait Categories

The traits can be organized into several functional categories:

### Core Functionality
- **[Unique ID](./traits/unique-id.md)** - Generate unique identifiers
- **[Modifier Classes](./traits/modifier-classes.md)** - Manage CSS modifier classes *(automatically included)*
- **[Reduce Bottom Space](./traits/reduce-bottom-spacing.md)** - Add spacing control options

### Content Enhancement
- **[Icons](./traits/icons.md)** - Add icon selection and rendering
- **[Color Choices](./traits/color-choices.md)** - Integrate with theme color palettes
- **[Block Patterns](./traits/block-patterns.md)** - Render reusable block patterns

### Editor Control
- **[Editor Context Restriction](./traits/editor-restriction.md)** - Control where blocks can be used
- **[Post Type Restriction](./traits/post-type-restriction.md)** - Limit blocks to specific post types

### Integration
- **[Menu Integration](./traits/menu-rendering.md)** - Work with WordPress navigation menus

## Trait Dependencies

Some traits have dependencies that must be considered:

### Required Dependencies
- **Reduce Bottom Space** requires **Modifier Classes** (which is automatically included)

### Optional Dependencies
- **Color Choices** works well with **Modifier Classes** for theme integration
- **Icons** works well with **Modifier Classes** for icon-specific styling
- **Editor Restriction** works well with **Post Type Restriction** for precise control

## Automatic Trait Inclusion

**Important:** The `Trait_Has_Modifier_Classes` is automatically included in the `Block` abstract class by default. This means:

- **No manual addition needed** - Modifier classes work out of the box
- **Default wrapper integration** - Classes are automatically applied when using the default template wrapper
- **Seamless operation** - No template code changes required for basic functionality

**Important:** The automatic calling of trait methods (like `get_modifier_class_string()`) only happens when the `use_default_wrapper_template()` method returns `true`. When this method returns `true`, the contents of your template file are automatically enclosed within the default block wrapper template, which calls trait methods automatically.

**All blocks must always provide a `template()` function that returns a valid path to a template file.** The `use_default_wrapper_template()` method only determines whether your template content is wrapped in the default wrapper.

## Common Trait Combinations

### Basic Content Block (Using Default Wrapper)
```php
<?php
use Creode_Blocks\Block;

class Basic_Content_Block extends Block {
    // No need to add Trait_Has_Modifier_Classes - it's included by default
    
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
    // Modifier classes automatically work with default wrapper
    // No template changes needed
}
?>
```

### Enhanced Content Block (Using Default Wrapper)
```php
<?php
use Creode_Blocks\Block;

class Enhanced_Content_Block extends Block {
    // Modifier Classes trait automatically included
    use Trait_Has_Reduce_Bottom_Space_Option; // Requires Modifier Classes
    use Trait_Has_Icons;
    use Trait_Has_Color_Choices;
    
    protected function modifier_classes(): array {
        return array(
            'primary',
            'secondary',
            'large',
            'small',
        );
    }
    
    private function icons(): array {
        return array(
            'star' => 'Star',
            'heart' => 'Heart',
            'checkmark' => 'Checkmark',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    // All functionality works automatically with default wrapper
    // Modifier classes, reduce bottom space, icons, and colors all integrate seamlessly
}
?>
```

### Navigation Block
```php
<?php
use Creode_Blocks\Block;

class Navigation_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    use Trait_Menu_Integration;
    // Modifier Classes trait automatically included
    
    protected function __construct() {
        parent::__construct();
        
        // Navigation blocks work best in site editor
        $this->restrict_to_site_editor();
    }
    
    protected function modifier_classes(): array {
        return array(
            'horizontal',
            'vertical',
            'mobile',
            'desktop',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_navigation_menu',
                'name'  => 'menu_location',
                'label' => 'Menu to Display',
                'type'  => 'select',
                'choices' => $this->get_menu_choices(),
            ),
        );
    }
}
?>
```

### Product Block
```php
<?php
use Creode_Blocks\Block;

class Product_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    // Modifier Classes trait automatically included
    use Trait_Has_Icons;
    use Trait_Has_Color_Choices;
    
    protected function __construct() {
        parent::__construct();
        
        // Only show in product posts
        $this->restrict_to_post_types( array( 'product' ) );
    }
    
    protected function modifier_classes(): array {
        return array(
            'featured',
            'on-sale',
            'out-of-stock',
            'new',
        );
    }
    
    private function icons(): array {
        return array(
            'star' => 'Star Rating',
            'heart' => 'Favorite',
            'share' => 'Share',
            'cart' => 'Add to Cart',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_product_icon',
                'name'  => 'icon',
                'label' => 'Product Icon',
                'type'  => 'select',
                'choices' => $this->get_icon_field_schema(
                    'field_product_icon',
                    true,
                    'icon'
                )['choices'],
            ),
            array(
                'key'   => 'field_product_theme',
                'name'  => 'theme',
                'label' => 'Product Theme',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
        );
    }
}
?>
```

### Hero Section Block
```php
<?php
use Creode_Blocks\Block;

class Hero_Section_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    // Modifier Classes trait automatically included
    use Trait_Has_Color_Choices;
    use Trait_Block_Pattern_Options;
    
    protected function __construct() {
        parent::__construct();
        
        // Hero sections work best in site editor
        $this->restrict_to_site_editor();
    }
    
    protected function modifier_classes(): array {
        return array(
            'full-height',
            'centered',
            'left-aligned',
            'right-aligned',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_hero_background',
                'name'  => 'background_color',
                'label' => 'Background Color',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
            array(
                'key'   => 'field_hero_content_pattern',
                'name'  => 'content_pattern',
                'label' => 'Content Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
            ),
        );
    }
}
?>
```

## Advanced Trait Combinations

### Context-Aware Block
```php
<?php
use Creode_Blocks\Block;

class Context_Aware_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    use Trait_Restrict_To_Post_Types;
    // Modifier Classes trait automatically included
    use Trait_Has_Icons;
    use Trait_Has_Color_Choices;
    
    protected function __construct() {
        parent::__construct();
        
        // Apply context-aware restrictions
        $this->apply_context_restrictions();
    }
    
    private function apply_context_restrictions() {
        // Check if we're in a site editor context
        if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {
            $this->restrict_to_site_editor();
        } else {
            $this->restrict_to_post_editor();
        }
        
        // Restrict to specific post types
        $this->restrict_to_post_types( array( 'post', 'page', 'product' ) );
    }
    
    protected function modifier_classes(): array {
        $classes = array( 'default' );
        
        // Add context-specific classes
        if ( is_front_page() ) {
            $classes[] = 'homepage';
        }
        
        if ( is_page() ) {
            $classes[] = 'page';
        }
        
        return $classes;
    }
    
    private function icons(): array {
        return array(
            'star' => 'Star',
            'heart' => 'Heart',
            'checkmark' => 'Checkmark',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    protected function fields(): array {
        $fields = array();
        
        // Add context-specific fields
        if ( $this->is_site_editor_context() ) {
            $fields[] = array(
                'key'   => 'field_global_setting',
                'name'  => 'global_setting',
                'label' => 'Global Setting',
                'type'  => 'text',
            );
        }
        
        $fields[] = array(
            'key'   => 'field_content_icon',
            'name'  => 'icon',
            'label' => 'Content Icon',
            'type'  => 'select',
            'choices' => $this->get_icon_field_schema(
                'field_content_icon',
                true,
                'icon'
            )['choices'],
        );
        
        $fields[] = array(
            'key'   => 'field_content_theme',
            'name'  => 'theme',
            'label' => 'Content Theme',
            'type'  => 'radio',
            'choices' => $this->get_color_choices(),
        );
        
        return $fields;
    }
    
    private function is_site_editor_context(): bool {
        return defined( 'WP_IS_SITE_EDITOR' ) && WP_IS_SITE_EDITOR;
    }
}
?>
```

### Flexible Layout Block
```php
<?php
use Creode_Blocks\Block;

class Flexible_Layout_Block extends Block {
    use Trait_Has_Unique_Id;
    // Modifier Classes trait automatically included
    use Trait_Has_Reduce_Bottom_Space_Option; // Requires Modifier Classes
    use Trait_Has_Icons;
    use Trait_Has_Color_Choices;
    use Trait_Block_Pattern_Options;
    
    protected function modifier_classes(): array {
        $classes = array(
            'default',
            'narrow',
            'wide',
            'full-width',
        );
        
        // Add spacing modifier if enabled
        if ( ! empty( $this->get_field( 'reduce_bottom_space' ) ) ) {
            $classes[] = 'reduce-bottom-space';
        }
        
        return $classes;
    }
    
    private function icons(): array {
        return array(
            'layout-1' => 'Layout 1',
            'layout-2' => 'Layout 2',
            'layout-3' => 'Layout 3',
        );
    }
    
    protected function template(): string {
        return __DIR__ . '/templates/block.php';
    }
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_layout_icon',
                'name'  => 'layout_icon',
                'label' => 'Layout Icon',
                'type'  => 'select',
                'choices' => $this->get_icon_field_schema(
                    'field_layout_icon',
                    true,
                    'layout_icon'
                )['choices'],
            ),
            array(
                'key'   => 'field_layout_theme',
                'name'  => 'layout_theme',
                'label' => 'Layout Theme',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
            array(
                'key'   => 'field_content_pattern',
                'name'  => 'content_pattern',
                'label' => 'Content Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
            ),
        );
    }
    
    public function render() {
        $unique_id = $this->get_unique_id();
        $modifier_classes = $this->get_modifier_class_string( 'flexible-layout' );
        $layout_icon = $this->get_field( 'layout_icon' );
        $content_pattern = $this->get_field( 'content_pattern' );
        
        ?>
        <div id="<?php echo esc_attr( $unique_id ); ?>" 
             class="<?php echo esc_attr( $modifier_classes ); ?>">
            
            <?php if ( ! empty( $layout_icon ) ) : ?>
                <div class="flexible-layout__icon">
                    <?php echo $this->get_icon_img( 'flexible-layout', false, 'layout_icon' ); ?>
                </div>
            <?php endif; ?>
            
            <div class="flexible-layout__content">
                <?php if ( ! empty( $content_pattern ) ) : ?>
                    <?php $this->render_block_pattern( $content_pattern ); ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
?>
```

## Best Practices for Trait Usage

### 1. Start Simple
Begin with basic traits and add complexity as needed:
- **Modifier Classes** work automatically (no setup needed)
- Add **Reduce Bottom Space** if spacing control is needed
- Add **Icons** or **Color Choices** for enhanced functionality

### 2. Understand Automatic Inclusion
- **Modifier Classes** trait is automatically included
- No need to manually add it to your block classes
- Works seamlessly with the default template wrapper when enabled

### 3. Always Provide Templates
- **Every block must have a `template()` function**
- The function must return a valid path to a template file
- This is required regardless of wrapper settings

### 4. Understand Wrapper Behavior
- **`use_default_wrapper_template()` controls automatic integration**
- When `true`: Trait methods are called automatically by the wrapper
- When `false`: You must manually call trait methods in your templates

### 5. Consider Dependencies
Always check trait dependencies:
- **Reduce Bottom Space** requires **Modifier Classes** (automatically included)
- Some traits work better together than others

### 6. Plan for Performance
Be mindful of trait combinations:
- Too many traits can impact performance
- Consider if all functionality is necessary
- Use traits that complement each other

### 7. Test Thoroughly
Always test trait combinations:
- Verify all functionality works together
- Test in different contexts and post types
- Ensure error handling works correctly

### 8. Document Usage
Keep clear documentation:
- Document which traits are used
- Explain any special requirements
- Provide examples of usage

## Common Patterns

### Content Blocks (Default Wrapper)
- **Modifier Classes** (automatic) + **Reduce Bottom Space** + **Unique ID**
- Add **Icons** or **Color Choices** for enhancement

### Navigation Blocks
- **Editor Restriction** + **Menu Integration** + **Modifier Classes** (automatic)

### Product Blocks
- **Post Type Restriction** + **Icons** + **Color Choices** + **Modifier Classes** (automatic)

### Layout Blocks
- **Editor Restriction** + **Modifier Classes** (automatic) + **Block Patterns**

### Hero Sections
- **Editor Restriction** + **Color Choices** + **Block Patterns** + **Modifier Classes** (automatic)

## Troubleshooting

### Common Issues
1. **Trait not working** - Check if required dependencies are included
2. **Performance issues** - Review trait combinations and remove unnecessary ones
3. **Conflicts** - Ensure traits don't interfere with each other
4. **Missing functionality** - Verify all required methods are implemented

### Debugging Tips
1. **Check trait order** - Some traits may need to be loaded in specific order
2. **Verify dependencies** - Ensure all required traits are included
3. **Test individually** - Test each trait separately before combining
4. **Check error logs** - Look for PHP errors or warnings
5. **Verify automatic inclusion** - Remember that Modifier Classes works automatically
6. **Check wrapper settings** - Verify `use_default_wrapper_template()` returns the expected value
7. **Ensure template function exists** - Every block must have a `template()` method

## Conclusion

The trait system provides a powerful and flexible way to extend block functionality. By understanding how traits work together and following best practices, you can create sophisticated blocks that are both powerful and maintainable.

**Key Points:**
- **Modifier Classes** trait works automatically with the default wrapper when enabled
- **All blocks must provide a template function** - this is always required
- **`use_default_wrapper_template()` controls automatic integration** - understand when it affects trait behavior
- Start simple and add complexity gradually
- Always check dependencies and requirements
- Test thoroughly in different contexts
- Document your usage and requirements
- Consider performance implications
- Use traits that complement each other

With these guidelines, you'll be able to create blocks that leverage the full power of the trait system while maintaining clean, maintainable code.
