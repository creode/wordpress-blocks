---
title: Post Type Restriction Trait
editLink: false
---

# Post Type Restriction Trait

The `Trait_Restrict_To_Post_Types` provides blocks with the ability to control which post types they can be used with, allowing developers to create specialized blocks that only appear in relevant content areas.

## Purpose

This trait is designed to:
- Restrict blocks to specific post types
- Improve content editor experience by showing relevant blocks
- Prevent blocks from being used in inappropriate contexts
- Support specialized content workflows
- Enable post-type-specific functionality

## How It Works

The trait automatically:
1. Integrates with WordPress post type system
2. Filters block availability based on current post type
3. Provides methods to restrict blocks to specific post types
4. Handles post type detection and validation
5. Works with both built-in and custom post types

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    // ... rest of block implementation
}
```

### Restricting to Specific Post Types

```php
<?php
use Creode_Blocks\Block;

class Product_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Restrict to product post type only
        $this->restrict_to_post_types( array( 'product' ) );
    }
}
```

### Restricting to Multiple Post Types

```php
<?php
use Creode_Blocks\Block;

class Content_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Restrict to posts and pages
        $this->restrict_to_post_types( array( 'post', 'page' ) );
    }
}
```

### Restricting to Built-in Post Types

```php
<?php
use Creode_Blocks\Block;

class Post_Only_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Restrict to posts only
        $this->restrict_to_post_types( array( 'post' ) );
    }
}
```

## Available Methods

### `restrict_to_post_types( array $post_types )`

Restricts block availability to specified post types.

**Parameters:**
- `$post_types` (array) - Array of post type names to restrict to

**Returns:** `void`

**Example:**
```php
$this->restrict_to_post_types( array( 'post', 'page', 'product' ) );
```

## Post Type Examples

### Built-in Post Types

WordPress provides several built-in post types:

- **`post`** - Blog posts
- **`page`** - Static pages
- **`attachment`** - Media attachments
- **`revision`** - Post revisions
- **`nav_menu_item`** - Navigation menu items
- **`custom_css`** - Custom CSS
- **`oembed_cache`** - OEmbed cache

### Custom Post Types

Common custom post types include:

- **`product`** - E-commerce products
- **`event`** - Events and calendar items
- **`testimonial`** - Customer testimonials
- **`team`** - Team member profiles
- **`portfolio`** - Portfolio items
- **`faq`** - Frequently asked questions

## Use Cases

### Product-Specific Blocks

```php
<?php
class Product_Gallery_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Only show in product posts
        $this->restrict_to_post_types( array( 'product' ) );
    }
    
    protected function name(): string {
        return 'product-gallery';
    }
    
    protected function label(): string {
        return 'Product Gallery';
    }
}
?>
```

### Event-Specific Blocks

```php
<?php
class Event_Details_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Only show in event posts
        $this->restrict_to_post_types( array( 'event' ) );
    }
    
    protected function name(): string {
        return 'event-details';
    }
    
    protected function label(): string {
        return 'Event Details';
    }
}
?>
```

### Content-Type Specific Blocks

```php
<?php
class Blog_Content_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Only show in blog posts
        $this->restrict_to_post_types( array( 'post' ) );
    }
    
    protected function name(): string {
        return 'blog-content';
    }
    
    protected function label(): string {
        return 'Blog Content';
    }
}
?>
```

### Multi-Post Type Blocks

```php
<?php
class Flexible_Content_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Show in posts, pages, and custom post types
        $this->restrict_to_post_types( array( 'post', 'page', 'product', 'event' ) );
    }
    
    protected function name(): string {
        return 'flexible-content';
    }
    
    protected function label(): string {
        return 'Flexible Content';
    }
}
?>
```

## Advanced Usage

### Conditional Post Type Restrictions

```php
<?php
class Smart_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Apply restrictions based on configuration
        $this->apply_smart_restrictions();
    }
    
    private function apply_smart_restrictions() {
        // Check if WooCommerce is active
        if ( class_exists( 'WooCommerce' ) ) {
            $this->restrict_to_post_types( array( 'post', 'page', 'product' ) );
        } else {
            $this->restrict_to_post_types( array( 'post', 'page' ) );
        }
    }
}
?>
```

### Dynamic Post Type Detection

```php
<?php
class Auto_Restrict_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Automatically detect available post types
        $this->auto_detect_post_types();
    }
    
    private function auto_detect_post_types() {
        $post_types = get_post_types( array( 'public' => true ) );
        
        // Filter out unwanted post types
        $excluded_types = array( 'attachment', 'revision', 'nav_menu_item' );
        $allowed_types = array_diff( $post_types, $excluded_types );
        
        $this->restrict_to_post_types( array_values( $allowed_types ) );
    }
}
?>
```

### Role-Based Restrictions

```php
<?php
class Role_Restricted_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    
    protected function __construct() {
        parent::__construct();
        
        // Apply restrictions based on user role
        $this->apply_role_based_restrictions();
    }
    
    private function apply_role_based_restrictions() {
        if ( current_user_can( 'manage_options' ) ) {
            // Admins can use in all post types
            $this->restrict_to_post_types( array( 'post', 'page', 'product', 'event' ) );
        } elseif ( current_user_can( 'edit_posts' ) ) {
            // Editors can use in posts and pages
            $this->restrict_to_post_types( array( 'post', 'page' ) );
        } else {
            // Authors can only use in posts
            $this->restrict_to_post_types( array( 'post' ) );
        }
    }
}
?>
```

## Integration with Other Traits

### With Editor Context Restriction

```php
<?php
class Specialized_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    use Trait_Restrict_To_Editor_Context;
    
    protected function __construct() {
        parent::__construct();
        
        // Restrict to specific post types and editor context
        $this->restrict_to_post_types( array( 'product' ) );
        $this->restrict_to_post_editor();
    }
}
?>
```

### With Icon Support

```php
<?php
class Product_Icon_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    use Trait_Has_Icons;
    
    protected function __construct() {
        parent::__construct();
        
        // Only show in product posts
        $this->restrict_to_post_types( array( 'product' ) );
    }
    
    private function icons(): array {
        return array(
            'star' => 'Star Rating',
            'heart' => 'Favorite',
            'share' => 'Share',
        );
    }
}
?>
```

### With Color Choices

```php
<?php
class Event_Color_Block extends Block {
    use Trait_Restrict_To_Post_Types;
    use Trait_Has_Color_Choices;
    
    protected function __construct() {
        parent::__construct();
        
        // Only show in event posts
        $this->restrict_to_post_types( array( 'event' ) );
    }
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_event_theme',
                'name'  => 'event_theme',
                'label' => 'Event Theme Color',
                'type'  => 'radio',
                'choices' => $this->get_color_choices(),
            ),
        );
    }
}
?>
```

## Error Handling

The trait gracefully handles various scenarios:

- **Invalid post types:** Gracefully handles non-existent post types
- **Post type detection failure:** Falls back to allowing the block everywhere
- **Filter conflicts:** Works alongside other block filtering systems
- **Missing post type data:** Handles cases where post type information is unavailable

## Best Practices

1. **Choose appropriate post types** - Restrict blocks to post types where they make sense
2. **Consider user experience** - Don't overly restrict blocks unless necessary
3. **Test restrictions** - Verify blocks appear/disappear in correct post types
4. **Document restrictions** - Let developers know which post types support each block
5. **Plan for flexibility** - Consider if blocks might be useful in multiple post types
6. **Follow WordPress patterns** - Use standard post type names when possible

## Common Restriction Patterns

- **Content blocks** → `post`, `page`
- **Product blocks** → `product`
- **Event blocks** → `event`
- **Portfolio blocks** → `portfolio`
- **Testimonial blocks** → `testimonial`
- **Team blocks** → `team`
- **FAQ blocks** → `faq`
- **News blocks** → `post`, `news`
- **Gallery blocks** → `post`, `page`, `gallery`
- **Form blocks** → `post`, `page`, `contact`
