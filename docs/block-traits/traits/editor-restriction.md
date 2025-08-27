---
title: Editor Restriction Trait
editLink: false
---

# Editor Restriction Trait

The `Trait_Restrict_To_Editor_Context` provides blocks with the ability to control where they can be used within the WordPress block editor, allowing developers to restrict blocks to specific editor contexts like the site editor or post editor.

## Purpose

This trait is designed to:
- Control block availability in different editor contexts
- Restrict blocks to specific editing environments
- Improve user experience by showing only relevant blocks
- Prevent blocks from being used in inappropriate contexts
- Support modern WordPress block editor workflows

## How It Works

The trait automatically:
1. Integrates with WordPress block editor context system
2. Filters block availability based on editor context
3. Provides convenient methods for common restrictions
4. Handles context detection and filtering
5. Works with both site and post editors

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    // ... rest of block implementation
}
```

### Restricting to Site Editor Only

```php
<?php
use Creode_Blocks\Block;

class Site_Only_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Restrict to site editor only
        $this->restrict_to_site_editor();
    }
}
```

### Restricting to Post Editor Only

```php
<?php
use Creode_Blocks\Block;

class Post_Only_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Restrict to post editor only
        $this->restrict_to_post_editor();
    }
}
```

### Custom Editor Context Restriction

```php
<?php
use Creode_Blocks\Block;

class Custom_Context_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Restrict to a specific editor context
        $this->restrict_to_editor_context( 'core/edit-widgets' );
    }
}
```

## Available Methods

### `restrict_to_site_editor()`

Restricts block availability to the site editor only.

**Returns:** `void`

**Example:**
```php
$this->restrict_to_site_editor();
```

### `restrict_to_post_editor()`

Restricts block availability to the post editor only.

**Returns:** `void`

**Example:**
```php
$this->restrict_to_post_editor();
```

### `restrict_to_editor_context( string $editor_context_name )`

Restricts block availability to a specified editor context.

**Parameters:**
- `$editor_context_name` (string) - The name of the editor context

**Returns:** `void`

**Example:**
```php
$this->restrict_to_editor_context( 'core/edit-site' );
```

## Editor Contexts

WordPress provides several editor contexts that you can restrict blocks to:

### Common Editor Contexts

- **`core/edit-post`** - Post and page editor
- **`core/edit-site`** - Site editor (FSE)
- **`core/edit-widgets`** - Widget editor
- **`core/customize-widgets`** - Customizer widget editor

### Custom Editor Contexts

You can also create custom editor contexts for specific use cases:

```php
<?php
// Create a custom editor context
add_action( 'enqueue_block_editor_assets', function() {
    wp_add_inline_script(
        'wp-blocks',
        'wp.blocks.registerBlockType( "my-plugin/my-block", {
            // ... block configuration
        });'
    );
});
?>
```

## Use Cases

### Site-Only Blocks

```php
<?php
class Header_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Headers should only be edited in site editor
        $this->restrict_to_site_editor();
    }
    
    protected function name(): string {
        return 'header';
    }
    
    protected function label(): string {
        return 'Header';
    }
}
?>
```

### Post-Only Blocks

```php
<?php
class Content_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Content blocks should only be used in post editor
        $this->restrict_to_post_editor();
    }
    
    protected function name(): string {
        return 'content';
    }
    
    protected function label(): string {
        return 'Content';
    }
}
?>
```

### Widget-Only Blocks

```php
<?php
class Widget_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Widget blocks should only be used in widget editor
        $this->restrict_to_editor_context( 'core/edit-widgets' );
    }
    
    protected function name(): string {
        return 'widget';
    }
    
    protected function label(): string {
        return 'Widget';
    }
}
?>
```

### Conditional Restrictions

```php
<?php
class Conditional_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Apply restrictions based on configuration
        if ( defined( 'RESTRICT_TO_SITE_EDITOR' ) && RESTRICT_TO_SITE_EDITOR ) {
            $this->restrict_to_site_editor();
        } else {
            $this->restrict_to_post_editor();
        }
    }
}
?>
```

## Advanced Usage

### Dynamic Context Detection

```php
<?php
class Smart_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Automatically detect appropriate context
        $this->auto_detect_context();
    }
    
    private function auto_detect_context() {
        // Check if we're in a site editor context
        if ( function_exists( 'wp_is_block_theme' ) && wp_is_block_theme() ) {
            $this->restrict_to_site_editor();
        } else {
            $this->restrict_to_post_editor();
        }
    }
}
?>
```

### Multiple Context Support

```php
<?php
class Flexible_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Allow in both site and post editors
        $this->allow_multiple_contexts();
    }
    
    private function allow_multiple_contexts() {
        // This block can be used in multiple contexts
        // No restrictions applied
    }
}
?>
```

### Context-Based Field Display

```php
<?php
class Context_Aware_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Restrict to site editor for global blocks
        $this->restrict_to_site_editor();
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
        
        return $fields;
    }
    
    private function is_site_editor_context(): bool {
        // Check if we're in site editor context
        return defined( 'WP_IS_SITE_EDITOR' ) && WP_IS_SITE_EDITOR;
    }
}
?>
```

## Integration with Other Traits

### With Menu Integration

```php
<?php
class Navigation_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    use Trait_Menu_Integration;
    
    protected function __construct() {
        parent::__construct();
        
        // Navigation blocks work best in site editor
        $this->restrict_to_site_editor();
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

### With Icon Support

```php
<?php
class Icon_Block extends Block {
    use Trait_Restrict_To_Editor_Context;
    use Trait_Has_Icons;
    
    protected function __construct() {
        parent::__construct();
        
        // Icon blocks can be used in both editors
        // No restrictions applied
    }
    
    private function icons(): array {
        return array(
            'star' => 'Star',
            'heart' => 'Heart',
        );
    }
}
?>
```

## Error Handling

The trait gracefully handles various scenarios:

- **Invalid context names:** Gracefully handles unknown editor contexts
- **Context detection failure:** Falls back to allowing the block everywhere
- **Filter conflicts:** Works alongside other block filtering systems
- **Missing editor context:** Handles cases where context is not available

## Best Practices

1. **Choose appropriate contexts** - Restrict blocks to contexts where they make sense
2. **Consider user experience** - Don't overly restrict blocks unless necessary
3. **Test restrictions** - Verify blocks appear/disappear in correct contexts
4. **Document restrictions** - Let developers know where blocks can be used
5. **Plan for flexibility** - Consider if blocks might be useful in multiple contexts
6. **Follow WordPress patterns** - Use standard context names when possible

## Common Restriction Patterns

- **Global blocks** → Site editor only
- **Content blocks** → Post editor only
- **Layout blocks** → Site editor only
- **Widget blocks** → Widget editor only
- **Navigation blocks** → Site editor only
- **Footer blocks** → Site editor only
