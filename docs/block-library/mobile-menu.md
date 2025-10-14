---
title: Mobile Menu Block
editLink: false
---

# Mobile Menu Block

## Description

The Mobile Menu Block provides a fully-featured mobile navigation system with JavaScript-powered interactions for opening, closing, and navigating through menu items. It includes accessibility features, custom menu walker support, and configurable behavior for sub-menu interactions.

## Features

- **Child Block Architecture** - Includes a Menu child block for content organization
- **JavaScript Interactions** - Built-in open/close, sub-menu toggles, and focus management
- **Custom Menu Walkers** - Support for toggle buttons and parent link variations
- **Accessibility Features** - Configurable focus states and keyboard navigation
- **Site Editor Only** - Restricted to site editor for template use
- **Extensible Configuration** - Override JavaScript config for custom behavior

## Built-in Variations

The library provides a `Side_Slide_Mobile_Menu_Block` class that extends the base mobile menu with side-slide functionality.

### Side Slide Mobile Menu

The `Side_Slide_Mobile_Menu_Block` extends the base mobile menu with:
- Focus state management for off-screen elements
- Parent links made inert (accessible through sub-menus)
- Side-slide animation styles
- Toggle walker with parent links

**Use the side-slide variation in your theme:**

```php
class My_Mobile_Menu_Block extends \Creode_Blocks\Side_Slide_Mobile_Menu_Block {
    // No additional configuration required
    // The side-slide functionality works out of the box
}

// Initialize your extended block
My_Mobile_Menu_Block::init();
```

**Add custom fields if needed:**

```php
class My_Mobile_Menu_Block extends \Creode_Blocks\Side_Slide_Mobile_Menu_Block {
    protected function fields(): array {
        $fields = parent::fields();
        
        // Optionally add custom fields
        $fields[] = array(
            'key' => 'field_menu_show_icons',
            'name' => 'show_icons',
            'label' => 'Show Menu Icons',
            'type' => 'true_false',
            'default_value' => false,
        );
        
        return $fields;
    }
}
```

## Use Cases

### Basic Mobile Menu
Extend the base mobile menu with custom fields.

```php
class My_Mobile_Menu_Block extends \Creode_Blocks\Mobile_Menu_Block {
    protected function fields(): array {
        $fields = parent::fields();
        
        // Add custom display options
        $fields[] = array(
            'key' => 'field_menu_theme',
            'name' => 'menu_theme',
            'label' => 'Menu Theme',
            'type' => 'select',
            'choices' => array(
                'light' => 'Light',
                'dark' => 'Dark',
            ),
        );
        
        return $fields;
    }
}
```

### Custom Menu Walker Configuration
Use different menu walkers for different navigation structures.

```php
class Custom_Mobile_Menu_Block extends \Creode_Blocks\Mobile_Menu_Block {
    public function get_menu_walker() {
        // Standard WordPress walker (no toggles)
        // return new \Walker_Nav_Menu();
        
        // Toggle buttons only (no parent links)
        // return new \Creode_Blocks\Toggle_Menu_Walker();
        
        // Both toggles and parent links (default)
        return new \Creode_Blocks\Toggle_Menu_Walker_With_Parent_Links();
    }
    
    public function get_menu_render_arguments(): array {
        return array(
            'menu_class' => 'mobile-nav__menu',
            'container' => false,
        );
    }
}
```

### Multi-Level Menu with Custom Behavior
Configure JavaScript behavior for complex menu structures.

```php
class Advanced_Mobile_Menu_Block extends \Creode_Blocks\Mobile_Menu_Block {
    protected function get_javascript_config(): array {
        return array(
            'setFocusableStates' => true,
            'makeParentLinksInert' => false, // Keep parent links clickable
            'animationDuration' => 300,
            'closeOnOutsideClick' => true,
        );
    }
    
    public function get_menu_render_arguments(): array {
        return array(
            'menu_class' => 'mobile-nav',
            'depth' => 3, // Allow 3 levels of nesting
        );
    }
}
```

## Child Blocks

The Mobile Menu Block includes:

| Child Block | Purpose | Key Features |
|------------|---------|--------------|
| **Menu** | Navigation menu container | Menu location selection, custom walker support |

## JavaScript Configuration

The block's JavaScript behavior can be customized through `get_javascript_config()`:

```php
protected function get_javascript_config(): array {
    return array(
        // When sub-menus are activated, make external elements non-focusable
        // Useful for slide-out menu formats
        'setFocusableStates' => false,
        
        // If setFocusableStates is true, also make parent links non-focusable
        // Forces users to access parent pages through sub-menu
        'makeParentLinksInert' => false,
    );
}
```

## Menu Walkers

Three menu walker options are available:

### Standard Walker
```php
public function get_menu_walker() {
    return new \Walker_Nav_Menu();
}
```
Standard WordPress menu with no modifications.

### Toggle Only Walker
```php
public function get_menu_walker() {
    return new \Creode_Blocks\Toggle_Menu_Walker();
}
```
Adds toggle buttons but removes parent links.

### Toggle with Parent Links Walker (Default)
```php
public function get_menu_walker() {
    return new \Creode_Blocks\Toggle_Menu_Walker_With_Parent_Links();
}
```
Adds toggle buttons AND keeps parent links accessible.

## Extending

### Menu with Search Bar

```php
class Searchable_Mobile_Menu_Block extends \Creode_Blocks\Mobile_Menu_Block {
    protected function child_blocks(): array {
        $blocks = parent::child_blocks();
        
        // Add search child block
        $blocks[] = new \Creode_Blocks\Child_Block(
            'search',
            'Search',
            array(
                array(
                    'key' => 'field_mobile_menu_search_placeholder',
                    'name' => 'search_placeholder',
                    'label' => 'Search Placeholder',
                    'type' => 'text',
                    'default_value' => 'Search...',
                ),
            ),
            __DIR__ . '/templates/search.php'
        );
        
        return $blocks;
    }
}
```

### Menu with Social Links

```php
class Social_Mobile_Menu_Block extends \Creode_Blocks\Mobile_Menu_Block {
    protected function child_blocks(): array {
        $blocks = parent::child_blocks();
        
        $blocks[] = new \Creode_Blocks\Child_Block(
            'social-links',
            'Social Links',
            array(
                array(
                    'key' => 'field_social_links',
                    'name' => 'social_links',
                    'label' => 'Social Links',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_social_platform',
                            'name' => 'platform',
                            'label' => 'Platform',
                            'type' => 'select',
                            'choices' => array(
                                'facebook' => 'Facebook',
                                'twitter' => 'Twitter',
                                'instagram' => 'Instagram',
                            ),
                        ),
                        array(
                            'key' => 'field_social_url',
                            'name' => 'url',
                            'label' => 'URL',
                            'type' => 'url',
                        ),
                    ),
                ),
            ),
            __DIR__ . '/templates/social-links.php'
        );
        
        return $blocks;
    }
}
```

## Assets

- **JavaScript**: `/blocks/mobile-menu/assets/mobile-menu.js`
- **Styles**: 
  - `/blocks/mobile-menu/assets/_mobile-menu.scss`
  - `/blocks/mobile-menu/assets/_mobile-menu--side-slide-base.scss` (Side-slide variation)
  - `/blocks/mobile-menu/assets/_mobile-menu--side-slide-1.scss` (Side-slide variation)

## Related Blocks

- [Site Header Block](/block-library/site-header) - Parent header container
- [Desktop Menu Block](/block-library/desktop-menu) - Desktop navigation counterpart
- [Integrated Menu Block](/utility-blocks/integrated-menu) - Utility menu integration

