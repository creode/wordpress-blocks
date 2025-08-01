---
title: Upgrading
editLink: false
---

# Upgrading
This guide covers breaking changes between versions of the block plugin. If you are upgrading from a version prior to 1.x, you will need to follow the instructions below.

## 1.x Changes

### 1.10.0
#### SCSS File Generation
This change introduces the capability for blocks to be generated with an SCSS file. This file is added to the `assets` directory of the block. This starts to tie in nicely with the block functionality inside the new `creode/wordpress-theme` package as block CSS can be added as part of the block generation process automatically and recompiled with default settings. This gives a nice productivity boost for developers.

### 1.9.0
Version 1.9.0 introduces a new composer dependency for the block plugin. This dependency removes the requirement for a `loader.php` file in the mu-plugins directory and instead copies the mu-plugin.php file into the mu-plugins directory. This solves an issue where all mu-plugins were being loaded under one single mu-plugin.

The `loader.php` file should therefore be removed from your project.

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

### Rector ruleset
We have created a Rector ruleset to help you upgrade your blocks. This can be used to automatically make your blocks compatible with the new version.

#### Installation
You can install this ruleset by running the following command:

```bash
composer require --dev creode/wordpress-blocks-rector
```

#### Usage
Once done you need to run the following command to upgrade your blocks, take specific note of the `{theme-name}` placeholder which should be replaced with the name of your WordPress theme:

```bash
vendor/bin/rector process wp-content/themes/{theme-name} --config=vendor/creode/wordpress-blocks-rector/config/blocks-1-0.php
```

The rector project can be found here: https://github.com/creode/wordpress-blocks-rector.

This will automatically make your blocks compatible with the new version.

#### Uninstallation
After running the command, you can uninstall the ruleset by running the following command:

```bash
composer remove --dev creode/wordpress-blocks-rector
```
