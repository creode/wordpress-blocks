---
title: Block Pattern Options Trait
editLink: false
---

# Block Pattern Options Trait

The `Trait_Block_Pattern_Options` provides blocks with the ability to reference and render reusable block patterns, allowing content editors to insert predefined content structures while maintaining consistency across the site.

## Purpose

This trait is designed to:
- Allow blocks to reference reusable block patterns
- Provide ACF field options for pattern selection
- Enable dynamic pattern rendering within blocks
- Maintain consistency across different content areas
- Simplify content management for editors

## How It Works

The trait automatically:
1. Scans for available reusable blocks (patterns) in the database
2. Generates ACF choice fields with pattern options
3. Provides methods to render patterns by slug
4. Supports both direct pattern rendering and post-context rendering
5. Integrates with WordPress's reusable block system

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Block_Pattern_Options;
    
    // ... rest of block implementation
}
```

### Adding Pattern Selection Fields

Use the `get_block_pattern_choices()` method to create ACF fields:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Block_Pattern_Options;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_my_block_pattern',
                'name'  => 'pattern',
                'label' => 'Content Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
            ),
        );
    }
}
```

### Rendering Patterns in Templates

```php
<?php
$pattern_slug = $this->get_field( 'pattern' );

if ( ! empty( $pattern_slug ) ) {
    $this->render_block_pattern( $pattern_slug );
}
?>
```

## Available Methods

### `get_block_pattern_choices()`

Returns all configured block patterns for use in ACF select fields.

**Returns:** `array` - An array of pattern choices with slugs as keys and titles as values

**Example:**
```php
$choices = $this->get_block_pattern_choices();
// Returns: array(
//     '' => 'None',
//     'hero-section' => 'Hero Section',
//     'feature-grid' => 'Feature Grid',
//     'testimonial' => 'Testimonial',
// )
```

### `render_block_pattern( string $block_pattern_slug )`

Renders a block pattern by slug.

**Parameters:**
- `$block_pattern_slug` (string) - The slug of the pattern to render

**Returns:** `void` - Outputs the pattern HTML directly

**Example:**
```php
$this->render_block_pattern( 'hero-section' );
```

### `render_block_pattern_in_post_context( int $post_id, string $block_pattern_slug )`

Renders a block pattern in the context of a specific post.

**Parameters:**
- `$post_id` (int) - The ID of the post to render the pattern in context of
- `$block_pattern_slug` (string) - The slug of the pattern to render

**Returns:** `void` - Outputs the pattern HTML directly

**Example:**
```php
$this->render_block_pattern_in_post_context( 123, 'related-posts' );
```

## Creating Reusable Block Patterns

Before using this trait, you need to create reusable block patterns in WordPress:

### Method 1: Block Editor

1. Create a new post with the "Reusable" block type
2. Build your pattern using blocks
3. Save it with a descriptive name
4. The pattern will be available for selection

### Method 2: Programmatically

```php
<?php
// Create a reusable block programmatically
$pattern_content = '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="wp-block-heading has-text-align-center">Hero Title</h2>
    <!-- /wp:heading -->
    
    <!-- wp:paragraph {"align":"center"} -->
    <p class="has-text-align-center">Hero description text goes here.</p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->';

$pattern_post = array(
    'post_title'   => 'Hero Section',
    'post_content' => $pattern_content,
    'post_status'  => 'publish',
    'post_type'    => 'wp_block',
);

wp_insert_post( $pattern_post );
?>
```

## Template Usage

### Basic Pattern Rendering

```php
<?php
$pattern_slug = $this->get_field( 'pattern' );

if ( ! empty( $pattern_slug ) ) {
    ?>
    <div class="my-block__pattern">
        <?php $this->render_block_pattern( $pattern_slug ); ?>
    </div>
    <?php
}
?>
```

### Conditional Pattern Rendering

```php
<?php
$pattern_slug = $this->get_field( 'pattern' );
$show_pattern = $this->get_field( 'show_pattern' );

if ( $show_pattern && ! empty( $pattern_slug ) ) {
    ?>
    <div class="my-block__pattern my-block__pattern--<?php echo esc_attr( $pattern_slug ); ?>">
        <?php $this->render_block_pattern( $pattern_slug ); ?>
    </div>
    <?php
}
?>
```

### Multiple Pattern Support

```php
<?php
$primary_pattern = $this->get_field( 'primary_pattern' );
$secondary_pattern = $this->get_field( 'secondary_pattern' );
?>

<div class="my-block">
    <?php if ( ! empty( $primary_pattern ) ) : ?>
        <div class="my-block__primary-pattern">
            <?php $this->render_block_pattern( $primary_pattern ); ?>
        </div>
    <?php endif; ?>
    
    <?php if ( ! empty( $secondary_pattern ) ) : ?>
        <div class="my-block__secondary-pattern">
            <?php $this->render_block_pattern( $secondary_pattern ); ?>
        </div>
    <?php endif; ?>
</div>
```

## Use Cases

### Content Blocks with Pattern Options

```php
<?php
class Content_Block extends Block {
    use Trait_Block_Pattern_Options;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_content_block_pattern',
                'name'  => 'content_pattern',
                'label' => 'Content Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
                'instructions' => 'Choose a predefined content pattern to display.',
            ),
        );
    }
}
```

### Section Blocks with Multiple Patterns

```php
<?php
class Section_Block extends Block {
    use Trait_Block_Pattern_Options;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_section_header_pattern',
                'name'  => 'header_pattern',
                'label' => 'Header Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
            ),
            array(
                'key'   => 'field_section_footer_pattern',
                'name'  => 'footer_pattern',
                'label' => 'Footer Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
            ),
        );
    }
}
```

### Landing Page Blocks

```php
<?php
class Landing_Page_Block extends Block {
    use Trait_Block_Pattern_Options;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_landing_hero_pattern',
                'name'  => 'hero_pattern',
                'label' => 'Hero Section Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
            ),
            array(
                'key'   => 'field_landing_cta_pattern',
                'name'  => 'cta_pattern',
                'label' => 'Call-to-Action Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
            ),
        );
    }
}
```

## CSS Integration

### Basic Pattern Styling

```scss
.my-block__pattern {
    margin: 2rem 0;
    
    // Style patterns within your block
    .wp-block-group {
        // Override default WordPress styles if needed
    }
    
    // Pattern-specific styling
    &--hero-section {
        background-color: var(--wp--preset--color--primary);
        color: white;
        padding: 3rem 0;
    }
    
    &--feature-grid {
        background-color: var(--wp--preset--color--secondary);
        padding: 2rem 0;
    }
}
```

### Responsive Pattern Handling

```scss
.my-block__pattern {
    &--hero-section {
        @media (max-width: 768px) {
            padding: 2rem 0;
            
            .wp-block-heading {
                font-size: 1.5rem;
            }
        }
    }
}
```

## Advanced Usage

### Dynamic Pattern Filtering

You can filter the available patterns using WordPress hooks:

```php
<?php
// Filter patterns for a specific block
add_filter( 'block-my-block-pattern-choices', function( $choices ) {
    // Only show certain patterns
    $allowed_patterns = array( 'hero-section', 'feature-grid' );
    
    return array_intersect_key( $choices, array_flip( $allowed_patterns ) );
});
?>
```

### Pattern Context Switching

```php
<?php
class Context_Aware_Block extends Block {
    use Trait_Block_Pattern_Options;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_context_pattern',
                'name'  => 'context_pattern',
                'label' => 'Context Pattern',
                'type'  => 'select',
                'choices' => $this->get_block_pattern_choices(),
            ),
        );
    }
    
    public function render() {
        $pattern_slug = $this->get_field( 'context_pattern' );
        
        if ( ! empty( $pattern_slug ) ) {
            // Render pattern in current post context
            $this->render_block_pattern_in_post_context( get_the_ID(), $pattern_slug );
        }
    }
}
?>
```

## Error Handling

The trait gracefully handles various scenarios:

- **No patterns available:** Returns empty choices array
- **Invalid pattern slug:** Gracefully handles missing patterns
- **Pattern rendering failure:** Continues execution without breaking
- **Database errors:** Falls back gracefully

## Best Practices

1. **Create meaningful patterns** - Design patterns that serve specific purposes
2. **Keep patterns focused** - Each pattern should have a single, clear purpose
3. **Test pattern rendering** - Verify patterns work correctly in different contexts
4. **Document pattern usage** - Let editors know when and how to use different patterns
5. **Consider performance** - Large patterns may impact page load times
6. **Maintain consistency** - Use patterns to ensure design consistency across the site

## Common Pattern Types

- **Hero Sections:** Landing page headers with titles and CTAs
- **Feature Grids:** Product or service feature displays
- **Testimonials:** Customer feedback and reviews
- **Contact Forms:** Standardized contact information
- **Navigation Elements:** Consistent navigation components
- **Footer Content:** Standardized footer information
