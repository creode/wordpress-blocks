---
title: Desktop Menu Block
editLink: false
---

# Desktop Menu Block

## Description

The Desktop Menu Block renders a WordPress navigation menu specifically designed for desktop layouts. It integrates with WordPress menu locations and provides a clean, accessible navigation structure. This block uses the Menu Integration trait for simplified menu rendering.

## Features

- **Menu Location Selection** - Choose from registered WordPress menu locations
- **Menu Integration Trait** - Simplified menu rendering with built-in helpers
- **Site Editor Only** - Restricted to site editor for template use
- **No Default Wrapper** - Provides complete control over HTML structure
- **Customizable Render Arguments** - Full control over `wp_nav_menu()` parameters

## Use Cases

### Basic Desktop Navigation
Extend the desktop menu with custom fields.

```php
class My_Desktop_Menu_Block extends \Creode_Blocks\Desktop_Menu_Block {
    protected function fields(): array {
        $fields = parent::fields();
        
        // Add custom menu alignment field
        $fields[] = array(
            'key' => 'field_menu_alignment',
            'name' => 'menu_alignment',
            'label' => 'Menu Alignment',
            'type' => 'select',
            'choices' => array(
                'left' => 'Left',
                'center' => 'Center',
                'right' => 'Right',
            ),
        );
        
        return $fields;
    }
}
```

### Custom Menu with Specific Classes
Add custom CSS classes and container elements to your menu.

```php
class Styled_Desktop_Menu_Block extends \Creode_Blocks\Desktop_Menu_Block {
    public function get_menu_render_arguments(): array {
        return array(
            'menu_class' => 'primary-nav__menu',
            'container' => 'nav',
            'container_class' => 'primary-nav',
            'depth' => 2,
            'fallback_cb' => false,
        );
    }
}
```

### Menu with Custom Walker
Implement a custom menu walker for advanced menu structures.

```php
class Advanced_Desktop_Menu_Block extends \Creode_Blocks\Desktop_Menu_Block {
    public function get_menu_render_arguments(): array {
        return array(
            'walker' => new My_Custom_Menu_Walker(),
            'menu_class' => 'advanced-menu',
            'items_wrap' => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
        );
    }
}
```

### Conditional Menu Fields
Add fields for different menu contexts.

```php
class Conditional_Desktop_Menu_Block extends \Creode_Blocks\Desktop_Menu_Block {
    protected function fields(): array {
        $fields = parent::fields();
        
        $fields[] = array(
            'key' => 'field_desktop_menu_logged_in',
            'name' => 'logged_in_menu',
            'label' => 'Logged In Menu',
            'type' => 'select',
            'choices' => $this->get_menu_choices(),
            'instructions' => 'Alternative menu to show for logged in users',
        );
        
        return $fields;
    }
}

```

## Extending

### Adding Menu Descriptions

```php
class Descriptive_Menu_Block extends \Creode_Blocks\Desktop_Menu_Block {
    public function get_menu_render_arguments(): array {
        return array(
            'menu_class' => 'menu-with-descriptions',
            'walker' => new Walker_Nav_Menu_With_Descriptions(),
        );
    }
}
```

### Mega Menu Support

```php
class Mega_Menu_Block extends \Creode_Blocks\Desktop_Menu_Block {
    protected function fields(): array {
        $fields = parent::fields();
        
        $fields[] = array(
            'key' => 'field_desktop_menu_enable_mega',
            'name' => 'enable_mega_menu',
            'label' => 'Enable Mega Menu',
            'type' => 'true_false',
            'default_value' => false,
        );
        
        return $fields;
    }
    
    public function get_menu_render_arguments(): array {
        $enable_mega = $this->get_field('enable_mega_menu');
        
        return array(
            'menu_class' => $enable_mega ? 'mega-menu' : 'standard-menu',
            'walker' => $enable_mega ? new Mega_Menu_Walker() : null,
        );
    }
}
```

### Menu with Icons

```php
class Icon_Menu_Block extends \Creode_Blocks\Desktop_Menu_Block {
    public function get_menu_render_arguments(): array {
        return array(
            'walker' => new Icon_Menu_Walker(),
            'menu_class' => 'icon-menu',
            'link_before' => '<span class="menu-item__icon">',
            'link_after' => '</span><span class="menu-item__text">',
        );
    }
}
```

## Menu Integration Trait

The block uses `Trait_Menu_Integration` which provides:

- `get_menu_choices()` - Returns array of available menu locations
- Easy integration with WordPress menu system
- Consistent menu location handling across blocks

## Assets

- **Styles**: `/blocks/desktop-menu/assets/_desktop-menu.scss`

## Related Blocks

- [Mobile Menu Block](/block-library/mobile-menu) - Mobile navigation counterpart
- [Site Header Block](/block-library/site-header) - Parent header container
- [Integrated Menu Block](/utility-blocks/integrated-menu) - Utility menu integration

