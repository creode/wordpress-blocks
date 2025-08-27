---
title: Block Traits Introduction
editLink: false
---

# Block Traits Introduction

The plugin includes a comprehensive library of PHP traits that are designed to extend the functionality of block classes that inherit from the `Creode_Blocks\Block` abstract class.

## What are Traits?

Traits are a PHP mechanism that allows you to reuse code across multiple classes without using inheritance. In the context of this plugin, traits provide commonly used functionality and behavior to blocks, making them more modular and easier to maintain.

## How Traits Work

Traits can be added to any block class using the `use` statement:

```php
<?php
use Creode_Blocks\Block;

class My_Block extends Block {
    use Trait_Has_Icons;
    use Trait_Has_Modifier_Classes;
    
    // ... rest of block implementation
}
```

## Automatic Trait Inclusion

**Important:** Some traits are automatically included in the `Block` abstract class by default:

- **`Trait_Has_Modifier_Classes`** - Automatically included, no need to add manually
- **Other traits** - Must be explicitly added as needed

**Important:** The automatic calling of trait methods (like `get_modifier_class_string()`) only happens when the `use_default_wrapper_template()` method returns `true`. When this method returns `true`, the contents of your template file are automatically enclosed within the default block wrapper template, which calls trait methods automatically.

**All blocks must always provide a `template()` function that returns a valid path to a template file.** The `use_default_wrapper_template()` method only determines whether your template content is wrapped in the default wrapper.

## Auto-Initialization

Many traits automatically initialize when added to a block class. This means you don't need to manually call setup functions - they happen automatically. For more details, see the [Auto Initialization](./auto-initialization.md) guide.

## Available Traits

The plugin provides the following traits, each designed for specific functionality:

### Core Functionality
- **[Unique ID](./traits/unique-id.md)** - Generate unique identifiers for blocks
- **[Modifier Classes](./traits/modifier-classes.md)** - Manage CSS modifier classes *(automatically included)*
- **[Reduce Bottom Space](./traits/reduce-bottom-spacing.md)** - Add spacing control options *(requires Modifier Classes)*

### Content Enhancement
- **[Icons](./traits/icons.md)** - Add icon selection and rendering capabilities
- **[Color Choices](./traits/color-choices.md)** - Integrate with theme color palettes
- **[Block Patterns](./traits/block-patterns.md)** - Render reusable block patterns

### Editor Control
- **[Editor Context Restriction](./traits/editor-restriction.md)** - Control where blocks can be used
- **[Post Type Restriction](./traits/post-type-restriction.md)** - Limit blocks to specific post types

### Integration
- **[Menu Integration](./traits/menu-rendering.md)** - Work with WordPress navigation menus

## Getting Started

For a comprehensive overview of how all traits work together, see the **[Traits Overview](./traits-overview.md)** guide, which includes:

- **Trait Categories** - How traits are organized by function
- **Dependencies** - Which traits require others to function
- **Common Combinations** - Practical examples of trait usage
- **Advanced Patterns** - Complex trait combinations
- **Best Practices** - Guidelines for effective trait usage

## Best Practices

1. **Use only what you need** - Don't add traits that provide functionality you won't use
2. **Check dependencies** - Some traits require others to function properly
3. **Follow naming conventions** - Traits follow the `Trait_` prefix convention
4. **Consider performance** - Traits are loaded at runtime, so keep them focused
5. **Start simple** - Begin with basic traits and add complexity as needed
6. **Leverage defaults** - Use the default template wrapper for automatic trait integration when possible
7. **Understand automatic inclusion** - Some traits work out of the box without manual addition
8. **Always provide templates** - Every block must have a `template()` function
9. **Understand wrapper behavior** - Know when `use_default_wrapper_template()` affects trait integration

## Creating Custom Traits

You can create your own traits that follow the same patterns. See the [Auto Initialization](./auto-initialization.md) guide for details on how to implement auto-initializing traits.

## Next Steps

- **New to traits?** Start with the [Traits Overview](./traits-overview.md) for practical examples
- **Want to understand auto-initialization?** Read the [Auto Initialization](./auto-initialization.md) guide
- **Ready to implement?** Choose a trait from the [Available Traits](./traits-overview.md) section and follow its documentation
- **Using default wrapper?** Check the [Modifier Classes](./traits/modifier-classes.md) guide to see how automatic integration works
- **Need custom templates?** Understand how `use_default_wrapper_template()` affects trait behavior
