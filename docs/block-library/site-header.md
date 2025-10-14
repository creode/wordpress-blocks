---
title: Site Header Block
editLink: false
---

# Site Header Block

## Description

The Site Header Block is a comprehensive, production-ready header component designed for use in WordPress site templates. It provides a structured header layout with child blocks for logo, desktop menu, mobile menu toggle, and general content areas. The block includes JavaScript functionality for scroll interactions and sticky header behavior.

## Features

- **Child Block Architecture** - Pre-configured child blocks for common header components
- **Device Visibility Controls** - Show/hide elements based on device type
- **Modifier Classes** - Dynamic CSS classes for styling variations
- **Scroll Interactions** - Built-in JavaScript for sticky headers and scroll effects
- **Site Editor Only** - Restricted to site editor context for template use

## Use Cases

### Standard Site Header
Build a traditional site header with custom child blocks.

```php
// Extend the block for your theme
class My_Site_Header_Block extends \Creode_Blocks\Site_Header_Block {
    protected function child_blocks(): array {
        $blocks = parent::child_blocks();
        
        // Add announcement bar child block
        $blocks[] = new \Creode_Blocks\Child_Block(
            'announcement-bar',
            'Announcement Bar',
            array(
                array(
                    'key' => 'field_header_announcement',
                    'name' => 'announcement_text',
                    'label' => 'Announcement Text',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_header_announcement_link',
                    'name' => 'announcement_link',
                    'label' => 'Announcement Link',
                    'type' => 'url',
                ),
            ),
            __DIR__ . '/templates/announcement.php'
        );
        
        return $blocks;
    }
}
```

### Sticky Header with Custom Behavior
Customize the header styling using modifier classes.

```php
class Sticky_Header_Block extends \Creode_Blocks\Site_Header_Block {
    protected function modifier_classes(): array {
        $classes = parent::modifier_classes();
        
        // Add sticky class for CSS styling
        $classes[] = 'sticky-header';
        
        return $classes;
    }
}
```

### Header with Multiple Layouts
Allow users to select different header layouts via fields.

```php
class Flexible_Header_Block extends \Creode_Blocks\Site_Header_Block {
    protected function fields(): array {
        $fields = parent::fields();
        
        // Add layout selection field
        $fields[] = array(
            'key' => 'field_header_layout',
            'name' => 'header_layout',
            'label' => 'Header Layout',
            'type' => 'select',
            'choices' => array(
                'standard' => 'Standard',
                'centered' => 'Centered',
                'split' => 'Split (Logo Center)',
                'minimal' => 'Minimal',
            ),
            'default_value' => 'standard',
        );
        
        return $fields;
    }
    
    protected function modifier_classes(): array {
        $classes = parent::modifier_classes();
        
        // Add layout class based on user selection
        $layout = $this->get_field('header_layout');
        if ($layout) {
            $classes[] = 'header-layout-' . $layout;
        }
        
        return $classes;
    }
}
```

## Child Blocks

The Site Header Block includes the following child blocks:

| Child Block | Purpose | Key Features |
|------------|---------|--------------|
| **General** | Container for custom content | Device visibility controls |
| **Logo** | Site logo/branding | Renders `/images/logo.svg` from theme |
| **Desktop Menu** | Desktop navigation | Renders "desktop-menu" template part |
| **Mobile Menu Toggle** | Menu button | Toggles "mobile-menu" template part |

## Extending

### Custom Child Blocks

Add your own child blocks to the header:

```php
protected function child_blocks(): array {
    $blocks = parent::child_blocks();
    
    // Add search button child block
    $blocks[] = new \Creode_Blocks\Child_Block(
        'search-toggle',
        'Search Toggle',
        array(
            array(
                'key' => 'field_search_placeholder',
                'name' => 'search_placeholder',
                'label' => 'Search Placeholder',
                'type' => 'text',
                'default_value' => 'Search...',
            ),
        ),
        __DIR__ . '/templates/search-toggle.php',
        array(),
        'search'
    );
    
    return $blocks;
}
```

## Assets

- **JavaScript**: `/blocks/site-header/assets/site-header.js`
- **Styles**: `/blocks/site-header/assets/_site-header.scss`

