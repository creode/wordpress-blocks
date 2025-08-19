---
title: Upgrading
editLink: false
---

# Upgrading
This guide covers breaking changes between versions of the block plugin. If you are upgrading from a version prior to 2.x, you will need to follow the instructions below.

## Upgrading from 1.x to 2.x

### Changes to the header block
The header block has been updated as part of version 2. This improves the flexibility of the header block and allows for more customisation. If you are using the header block on your site, you will need to update any use statements from `Creode_Blocks\Header_Block` to `Creode_Blocks\Legacy_Header_Block`.

### Changes to the block class
#### Removal of the `category()` method
The block class has been updated in version 1 to remove the need for a `category()` method in blocks. This is now controlled by a filter that is applied in your theme. This change can be actioned manually for every block or you can use the Rector ruleset to automatically make your blocks compatible with the new version.

#### Removal of the `$instance` class property
The `$instance` class property has been removed from the block class as it is no longer required to function due to some internal changes to the block class.

### Rector ruleset
You can find the Rector setup instructions for this plugin [here](rector.md).

For version 2.x of the block plugin, you can use the following command to upgrade your blocks, take specific note of the `{theme-name}` placeholder which should be replaced with the name of your WordPress theme:

```bash
vendor/bin/rector process wp-content/themes/{theme-name} --config=vendor/creode/wordpress-blocks-rector/config/blocks-2-0-0.php
```

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
