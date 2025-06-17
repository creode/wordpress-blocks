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

### Rector ruleset
As part of the upgrade to 1.x of the block plugin, we have created a Rector ruleset to automatically make your blocks compatible with the new version.

To use the ruleset, the first step is to install Rector using this documentation: https://getrector.com/documentation.

You should now have a `rector.php` file in your project root.

You should then add the following to your `rector.php` file, take specific note of the `{{theme-name}}` placeholder which should be replaced with the name of your websites theme:

```php
declare(strict_types=1);

use Rector\Config\RectorConfig;
use Creode\Blocks\Utils\Rector\DisableDefaultWrapperTemplateRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/wp-content/themes/{{theme-name}}/blocks',
    ])
    ->withRules([
        DisableDefaultWrapperTemplateRector::class,
    ])
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
```

Once done you need add the following to your `composer.json` file:

```json
"autoload-dev": {
    "psr-4": {
        "Creode\\Blocks\\Utils\\Rector\\": "wp-content/mu-plugins/wordpress-blocks/utils/rector/src"
    }
}
```

Then run the following command:

```bash
composer dump-autoload
```

Finally you need to run the following command:

```bash
vendor/bin/rector process
```

This will automatically scan your theme blocks and them compatible with the new version.

Rector can then be removed from your project as it is no longer needed, changes can be discarded using git.
