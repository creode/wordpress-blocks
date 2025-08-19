---
title: Rector ruleset
editLink: false
---

# Rector ruleset
We have created a Rector ruleset to help you upgrade your blocks. This can be used to automatically make your blocks compatible with the new version.

## Installation
You can install this ruleset by running the following command:

```bash
composer require --dev creode/wordpress-blocks-rector
```

## Usage
Once done you need to run the following command to upgrade your blocks, take specific note of the `{theme-name}` and `{version-to-upgrade}` placeholders which should be replaced with the name of your WordPress theme and the version you are upgrading to:

```bash
vendor/bin/rector process wp-content/themes/{theme-name} --config=vendor/creode/wordpress-blocks-rector/config/blocks-{version-to-upgrade}-0.php
```

The rector project can be found here: https://github.com/creode/wordpress-blocks-rector.

This will automatically make your blocks compatible with the new version.

## Uninstallation
After running the command, you can uninstall the ruleset by running the following command:

```bash
composer remove --dev creode/wordpress-blocks-rector
```
