---
title: Integrated Pattern Block
editLink: false
---

# Integrated Pattern Block

## Description

The Integrated Pattern Block renders WordPress block patterns by their slug rather than their database ID. This ensures that pattern references remain valid across different environments (development, staging, production) where pattern IDs may differ, but pattern slugs stay consistent.

## Features

- **Slug-Based References** - Uses pattern slugs instead of database IDs
- **Environment Portable** - Works across different database instances
- **Template Safe** - Safe to use in template files and patterns
- **Block Pattern Trait** - Includes helper methods for pattern management
- **No Default Wrapper** - Complete control over HTML output
- **Utility Category** - Grouped with other utility blocks
- **Auto-initialized** - Available immediately without manual initialization

::: tip Utility Block
This block is automatically initialized by the plugin and ready to use. Simply add it in the block editor or include it in your block template structures. **Do not extend utility blocks** - they are designed to be used directly as-is.
:::

## Use Cases

### Post Template with Pattern
Render a consistent post card pattern for each post in a query loop.

```php
// Use the block in your template:
array(
    'core/post-template',
    array(),
    array(
        array(
            'acf/integrated-pattern',
            array(
                'data' => array(
                    'block_pattern' => 'post-card',
                ),
            ),
        ),
    ),
)
```

### Reusable Section Pattern
Include a reusable section pattern in multiple templates.

```php
// In any template or pattern:
array(
    'acf/integrated-pattern',
    array(
        'data' => array(
            'block_pattern' => 'cta-section',
        ),
    ),
)
```

## Why Use This Block?

### The Problem
WordPress patterns are stored as custom posts with database IDs. When template files are used on multiple environments, these IDs change, breaking your template references.

```php
// ❌ Core pattern block - breaks on database sync
array(
    'core/block',
    array('ref' => 456), // This ID won't exist on other environments
)
```

### The Solution
Integrated Pattern Block references patterns by slug, which is consistent across environments.

```php
// ✅ Integrated Pattern - works everywhere
array(
    'acf/integrated-pattern',
    array(
        'data' => array(
            'block_pattern' => 'hero-section', // Slug is the same everywhere
        ),
    ),
)
```

## Pattern Registration

To use this block effectively, register your patterns with consistent slugs:

```php
// In your theme's functions.php
register_block_pattern(
    'hero-section',
    array(
        'title' => __('Hero Section', 'textdomain'),
        'content' => '<!-- wp:group -->...<!-- /wp:group -->',
        'categories' => array('featured'),
    )
);

register_block_pattern(
    'post-card',
    array(
        'title' => __('Post Card', 'textdomain'),
        'content' => '<!-- wp:group -->...<!-- /wp:group -->',
        'categories' => array('posts'),
    )
);
```

## Related Blocks

- [Post Listing Block](/block-library/post-listing) - Often used together for post displays
- [Integrated Menu Block](/utility-blocks/integrated-menu) - Menu integration counterpart

## Best Practices

1. **Pattern Registration** - Register all patterns in your theme, don't rely on database-stored patterns
2. **Documentation** - Document which patterns your theme requires
3. **Testing** - Test pattern rendering across all environments
4. **Fallbacks** - Consider what happens if a pattern doesn't exist
5. **Categories** - Organize patterns into logical categories for easier selection

