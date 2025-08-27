---
title: Menu Integration Trait
editLink: false
---

# Menu Integration Trait

The `Trait_Menu_Integration` provides blocks with the ability to work with WordPress navigation menus, including menu selection fields, rendering methods, and location-based menu management.

## Purpose

This trait is designed to:
- Allow blocks to integrate with WordPress navigation menus
- Provide ACF field options for menu selection
- Enable dynamic menu rendering within blocks
- Support menu location-based rendering
- Simplify menu integration for content editors

## How It Works

The trait automatically:
1. Scans for available WordPress menu locations
2. Generates ACF choice fields with menu options
3. Provides methods to render menus by location
4. Handles menu ID resolution and validation
5. Integrates with WordPress's menu system

## Usage

### Basic Implementation

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Menu_Integration;
    
    // ... rest of block implementation
}
```

### Adding Menu Selection Fields

Use the `get_menu_choices()` method to create ACF fields:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Menu_Integration;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_my_block_menu',
                'name'  => 'menu_location',
                'label' => 'Menu to Display',
                'type'  => 'select',
                'choices' => $this->get_menu_choices(),
            ),
        );
    }
}
```

### Rendering Menus in Templates

```php
<?php
$menu_location = $this->get_field( 'menu_location' );

if ( ! empty( $menu_location ) ) {
    $this->render_menu_by_location( $menu_location );
}
?>
```

## Available Methods

### `get_menu_choices()`

Returns all WordPress menu locations for use in ACF select fields.

**Returns:** `array` - An array of menu choices with locations as keys and names as values

**Example:**
```php
$choices = $this->get_menu_choices();
// Returns: array(
//     '' => 'None',
//     'primary' => 'Primary Menu',
//     'footer' => 'Footer Menu',
//     'mobile' => 'Mobile Menu',
// )
```

### `render_menu_by_location( string $location, array $args = array() )`

Renders a menu by menu location.

**Parameters:**
- `$location` (string) - The menu location
- `$args` (array) - Optional array of arguments for rendering the menu

**Returns:** `void` - Outputs the menu HTML directly

**Example:**
```php
$this->render_menu_by_location( 'primary' );
```

### `get_menu_id_by_location( string $location )`

Returns the ID of a menu assigned to a specified location.

**Parameters:**
- `$location` (string) - The menu location

**Returns:** `int|null` - The menu ID or null if menu cannot be found

**Example:**
```php
$menu_id = $this->get_menu_id_by_location( 'primary' );
// Returns: 123 or null
```

## WordPress Menu Setup

Before using this trait, you need to register menu locations in your theme:

### Registering Menu Locations

```php
<?php
// In your theme's functions.php
function my_theme_setup() {
    register_nav_menus( array(
        'primary' => 'Primary Menu',
        'footer'  => 'Footer Menu',
        'mobile'  => 'Mobile Menu',
        'sidebar' => 'Sidebar Menu',
    ) );
}
add_action( 'after_setup_theme', 'my_theme_setup' );
```

### Assigning Menus to Locations

1. Go to **Appearance > Menus** in WordPress admin
2. Create or select a menu
3. In the "Menu Settings" section, check the desired location
4. Save the menu

## Template Usage

### Basic Menu Rendering

```php
<?php
$menu_location = $this->get_field( 'menu_location' );

if ( ! empty( $menu_location ) ) {
    ?>
    <nav class="my-block__navigation">
        <?php $this->render_menu_by_location( $menu_location ); ?>
    </nav>
    <?php
}
?>
```

### Custom Menu Arguments

```php
<?php
$menu_location = $this->get_field( 'menu_location' );

if ( ! empty( $menu_location ) ) {
    $menu_args = array(
        'container_class' => 'my-block__menu-container',
        'menu_class'      => 'my-block__menu-list',
        'fallback_cb'    => false,
    );
    
    $this->render_menu_by_location( $menu_location, $menu_args );
}
?>
```

### Conditional Menu Rendering

```php
<?php
$show_menu = $this->get_field( 'show_menu' );
$menu_location = $this->get_field( 'menu_location' );

if ( $show_menu && ! empty( $menu_location ) ) {
    ?>
    <div class="my-block__menu-wrapper">
        <h3 class="my-block__menu-title">Navigation</h3>
        <?php $this->render_menu_by_location( $menu_location ); ?>
    </div>
    <?php
}
?>
```

### Multiple Menu Support

```php
<?php
$primary_menu = $this->get_field( 'primary_menu' );
$secondary_menu = $this->get_field( 'secondary_menu' );
?>

<div class="my-block">
    <?php if ( ! empty( $primary_menu ) ) : ?>
        <nav class="my-block__primary-nav">
            <?php $this->render_menu_by_location( $primary_menu ); ?>
        </nav>
    <?php endif; ?>
    
    <?php if ( ! empty( $secondary_menu ) ) : ?>
        <nav class="my-block__secondary-nav">
            <?php $this->render_menu_by_location( $secondary_menu ); ?>
        </nav>
    <?php endif; ?>
</div>
```

## Use Cases

### Navigation Blocks

```php
<?php
class Navigation_Block extends Block {
    use Trait_Menu_Integration;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_navigation_menu',
                'name'  => 'menu_location',
                'label' => 'Menu to Display',
                'type'  => 'select',
                'choices' => $this->get_menu_choices(),
                'instructions' => 'Choose which menu to display in this navigation block.',
            ),
        );
    }
}
```

### Footer Menu Blocks

```php
<?php
class Footer_Menu_Block extends Block {
    use Trait_Menu_Integration;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_footer_menu',
                'name'  => 'footer_menu',
                'label' => 'Footer Menu',
                'type'  => 'select',
                'choices' => $this->get_menu_choices(),
            ),
        );
    }
}
```

### Sidebar Navigation

```php
<?php
class Sidebar_Navigation_Block extends Block {
    use Trait_Menu_Integration;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_sidebar_menu',
                'name'  => 'sidebar_menu',
                'label' => 'Sidebar Menu',
                'type'  => 'select',
                'choices' => $this->get_menu_choices(),
            ),
        );
    }
}
```

## CSS Integration

### Basic Menu Styling

```scss
.my-block__navigation {
    margin: 1rem 0;
    
    .my-block__menu-container {
        // Container styles
    }
    
    .my-block__menu-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        
        li {
            margin: 0.5rem 0;
            
            a {
                text-decoration: none;
                color: inherit;
                padding: 0.5rem;
                display: block;
                
                &:hover {
                    background-color: rgba(0, 0, 0, 0.1);
                }
            }
        }
    }
}
```

### Responsive Menu Handling

```scss
.my-block__navigation {
    .my-block__menu-list {
        @media (min-width: 768px) {
            flex-direction: row;
            
            li {
                margin: 0 1rem 0 0;
            }
        }
    }
}
```

### Menu State Styling

```scss
.my-block__navigation {
    .my-block__menu-list {
        li {
            &.current-menu-item {
                a {
                    font-weight: bold;
                    color: var(--wp--preset--color--primary);
                }
            }
            
            &.current-menu-parent {
                a {
                    color: var(--wp--preset--color--secondary);
                }
            }
        }
    }
}
```

## Advanced Usage

### Custom Menu Walker

```php
<?php
class Custom_Menu_Block extends Block {
    use Trait_Menu_Integration;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_custom_menu',
                'name'  => 'custom_menu',
                'label' => 'Custom Menu',
                'type'  => 'select',
                'choices' => $this->get_menu_choices(),
            ),
        );
    }
    
    public function render() {
        $menu_location = $this->get_field( 'custom_menu' );
        
        if ( ! empty( $menu_location ) ) {
            $menu_args = array(
                'walker' => new Custom_Menu_Walker(),
                'container_class' => 'custom-menu-container',
            );
            
            $this->render_menu_by_location( $menu_location, $menu_args );
        }
    }
}
?>
```

### Dynamic Menu Filtering

```php
<?php
// Filter menu choices for a specific block
add_filter( 'block-my-block-menu-choices', function( $choices ) {
    // Only show certain menu locations
    $allowed_locations = array( 'primary', 'footer' );
    
    return array_intersect_key( $choices, array_flip( $allowed_locations ) );
});
?>
```

### Menu Context Switching

```php
<?php
class Context_Aware_Menu_Block extends Block {
    use Trait_Menu_Integration;
    
    protected function fields(): array {
        return array(
            array(
                'key'   => 'field_context_menu',
                'name'  => 'context_menu',
                'label' => 'Context Menu',
                'type'  => 'select',
                'choices' => $this->get_menu_choices(),
            ),
        );
    }
    
    public function render() {
        $menu_location = $this->get_field( 'context_menu' );
        
        if ( ! empty( $menu_location ) ) {
            // Add context-specific menu arguments
            $menu_args = array();
            
            if ( is_front_page() ) {
                $menu_args['container_class'] = 'homepage-menu';
            } elseif ( is_page() ) {
                $menu_args['container_class'] = 'page-menu';
            }
            
            $this->render_menu_by_location( $menu_location, $menu_args );
        }
    }
}
?>
```

## Error Handling

The trait gracefully handles various scenarios:

- **No menu assigned:** Displays "No menu found." message
- **Invalid location:** Gracefully handles missing menu locations
- **Menu rendering failure:** Continues execution without breaking
- **No menu locations:** Returns empty choices array

## Best Practices

1. **Register meaningful locations** - Use descriptive names for menu locations
2. **Test menu rendering** - Verify menus display correctly in different contexts
3. **Consider mobile experience** - Ensure menus work well on all devices
4. **Use semantic markup** - Leverage proper HTML5 navigation elements
5. **Plan menu structure** - Design menus with clear hierarchy and purpose
6. **Test menu states** - Verify current page highlighting works correctly

## Common Menu Patterns

- **Primary Navigation:** Main site navigation
- **Footer Links:** Secondary navigation and legal links
- **Mobile Menu:** Collapsible mobile navigation
- **Sidebar Navigation:** Context-specific navigation
- **Breadcrumbs:** Page hierarchy navigation
- **Social Links:** Social media and external links