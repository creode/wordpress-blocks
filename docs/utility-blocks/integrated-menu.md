---
title: Integrated Menu Block
editLink: false
---

# Integrated Menu Block

## Description

The Integrated Menu Block renders WordPress navigation menus by menu location rather than menu ID. This ensures that menu references remain valid across different environments (development, staging, production) where menu IDs may differ, but menu locations stay consistent.

## Features

- **Menu Location Based** - References menus by registered location, not database ID
- **Environment Portable** - Works across different database instances
- **Template Safe** - Safe to use in template files and patterns
- **Menu Integration Trait** - Uses the same menu helpers as Desktop Menu Block
- **No Default Wrapper** - Complete control over HTML output
- **Utility Category** - Grouped with other utility blocks
- **Auto-initialized** - Available immediately without manual initialization

::: tip Utility Block
This block is automatically initialized by the plugin and ready to use. Simply add it in the block editor or include it in your block template structures. **Do not extend utility blocks** - they are designed to be used directly as-is.
:::

## Use Cases

### Pattern with Navigation Menu
Include a menu in a reusable pattern that will work in any environment.

```php
// Use the block in a pattern or template:
array(
    'acf/integrated-menu',
    array(
        'data' => array(
            'menu_location' => 'footer-menu',
        ),
    ),
)
```

### Footer Template with Multiple Menus
Build a footer template with several menu locations.

```php
// footer-template.php
array(
    'core/columns',
    array(),
    array(
        array(
            'core/column',
            array(),
            array(
                array(
                    'core/heading',
                    array('content' => 'Company'),
                ),
                array(
                    'acf/integrated-menu',
                    array(
                        'data' => array(
                            'menu_location' => 'footer-company',
                        ),
                    ),
                ),
            ),
        ),
        array(
            'core/column',
            array(),
            array(
                array(
                    'core/heading',
                    array('content' => 'Resources'),
                ),
                array(
                    'acf/integrated-menu',
                    array(
                        'data' => array(
                            'menu_location' => 'footer-resources',
                        ),
                    ),
                ),
            ),
        ),
    ),
)
```

## Why Use This Block?

### The Problem
WordPress core blocks reference menus by their database ID. When template files are used on multiple environments, menu IDs change, breaking your templates.

```php
// ❌ Core navigation block - breaks on database sync
array(
    'core/navigation',
    array('ref' => 123), // This ID won't exist on other environments
)
```

### The Solution
Integrated Menu Block references menus by location, which is consistent across environments.

```php
// ✅ Integrated Menu - works everywhere
array(
    'acf/integrated-menu',
    array(
        'data' => array(
            'menu_location' => 'footer-menu', // Location is the same everywhere
        ),
    ),
)
```

## Registering Menu Locations

To use this block, you must register menu locations in your theme:

```php
// In your theme's functions.php
register_nav_menus(array(
    'primary' => __('Primary Menu', 'textdomain'),
    'footer-menu' => __('Footer Menu', 'textdomain'),
    'footer-company' => __('Footer Company Menu', 'textdomain'),
    'footer-resources' => __('Footer Resources Menu', 'textdomain'),
));
```

## Menu Integration Trait

Like the Desktop Menu Block, this block uses `Trait_Menu_Integration` which provides:

- `get_menu_choices()` - Returns array of registered menu locations
- Consistent menu handling across blocks
- Easy access to menu location information

## Related Blocks

- [Desktop Menu Block](/block-library/desktop-menu) - Desktop-specific menu with similar functionality
- [Mobile Menu Block](/block-library/mobile-menu) - Mobile menu implementation
- [Integrated Pattern Block](/utility-blocks/integrated-pattern) - Pattern integration counterpart

## Best Practices

1. **Consistent Naming** - Use the same menu location names across all environments
2. **Document Locations** - Keep a list of required menu locations in your theme documentation
3. **Fallback Handling** - Consider what happens if a menu location isn't assigned
4. **Testing** - Test menu rendering across all your environments
5. **Location Registration** - Always register menu locations in your theme, even if using this block

