---
title: Upgrading
editLink: false
---

# Upgrading
This guide covers breaking changes between versions of the block plugin. If you are upgrading from a version prior to 1.x, you will need to follow the instructions below.

## Upgrading from 0.x to 1.x

### Changes to the block class
As part of the upgrade to 1.x of the block plugin, the base block class now includes the `Trait_Has_Modifier_Classes` trait. This trait is used to add modifier classes to the block.

This change breaks existing blocks due to the requirement of a new `default-wrapper.php` template for blocks. In order to upgrade, you will need to add the following function declaration to any existing block classes created prior to 1.x:

```php
/**
 * {@inheritdoc}
 */
protected function use_default_wrapper_template(): bool {
    return false;
}
```

This ensures that the block will not use the default wrapper template.