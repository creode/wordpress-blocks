---
title: Quick Start
editLink: false
---

# Quick Start

## Requirements
This plugin requires the following to be installed and active on the WordPress site:
- Advanced Custom Fields Pro - A pro license is required to handle block creation.
- WP-CLI (Recommended) - This is used to create new blocks easily.
- Composer (Recommended) - This is used to install the plugin, though a zipped version can be downloaded from Github and placed in the `wp-content/mu-plugins` folder if required.

## Installation
The block library can be installed through composer using the following command:

```bash
composer require creode/wordpress-blocks
```

::: tip
This plugin is recommended to be installed as a mu-plugin. This is due to the fact that it provides a lot of infrastructural requirements. Installing through composer will already place this in the mu-plugins folder.
:::
