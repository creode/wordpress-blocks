---
title: Utility Blocks
editLink: false
---

# Utility Blocks

## Overview

Utility Blocks are specialized blocks designed to solve specific integration challenges in WordPress block development. Unlike the Block Library blocks which provide complete UI components, utility blocks handle technical problems related to content portability, pattern management, and menu integration.

## Purpose

These blocks exist to bridge gaps in WordPress core functionality and ensure your content remains portable across different environments (development, staging, production). They solve problems that would otherwise require hard-coded IDs or manual updates when moving content between environments.

## Key Benefits

- **Environment Portability** - Reference content by slug instead of database IDs
- **Content Consistency** - Patterns and menus work the same across all environments
- **Template Safety** - Safe to use in template files and reusable patterns
- **Easy Synchronization** - Content structure matches across database instances

## When to Use Utility Blocks

### Integrated Pattern Block
Use when you need to:
- Reference patterns by slug instead of ID
- Include patterns in template files
- Ensure patterns work across multiple environments
- Build reusable content structures that won't break on database sync

### Integrated Menu Block
Use when you need to:
- Reference menus by location instead of ID
- Include menus in template files
- Ensure menu references survive database migrations
- Build portable navigation structures

## Common Use Cases

### Building Reusable Templates

```php
// In a block template or pattern
array(
    'acf/integrated-pattern',
    array(
        'data' => array(
            'block_pattern' => 'hero-section',
        ),
    ),
)
```

The pattern slug `hero-section` will work on any environment where the pattern is registered, avoiding hard-coded post IDs.

### Creating Portable Navigation

```php
// In a header template
array(
    'acf/integrated-menu',
    array(
        'data' => array(
            'menu_location' => 'primary',
        ),
    ),
)
```

The menu location `primary` will render whatever menu is assigned to that location, regardless of the menu's database ID.

## Difference from Block Library

| Block Library | Utility Blocks |
|--------------|----------------|
| Complete UI components | Integration helpers |
| Designed for content areas | Designed for templates |
| Focus on presentation | Focus on portability |
| User-facing blocks | Developer-facing blocks |
| Extensive customization | Minimal configuration |

## Available Utility Blocks

### [Integrated Pattern Block](/utility-blocks/integrated-pattern)
Renders WordPress patterns by slug instead of ID, ensuring portability across environments.

### [Integrated Menu Block](/utility-blocks/integrated-menu)
Renders WordPress menus by location instead of ID, ensuring consistent navigation across environments.

## Best Practices

1. **Use in Templates** - These blocks are designed for use in template files and reusable patterns
2. **Slug Naming** - Use consistent, descriptive slugs for patterns across all environments
3. **Location Registration** - Ensure menu locations are registered identically across environments
4. **Documentation** - Document which patterns and menu locations your theme requires
5. **Testing** - Always test content portability between environments

## Category

Both utility blocks are registered under the `creode-utilities` category, keeping them separate from your main content blocks.

## Integration with Block Library

Utility blocks work seamlessly with Block Library blocks:

```php
// Post Listing with Integrated Pattern
array(
    'acf/post-listing',
    array(),
    array(
        array(
            'core/query',
            array(),
            array(
                array(
                    'core/post-template',
                    array(),
                    array(
                        array('acf/integrated-pattern'), // Portable post card pattern
                    ),
                ),
            ),
        ),
    ),
)
```

## Next Steps

Explore the individual utility block pages to learn more about their specific features and implementation examples.

