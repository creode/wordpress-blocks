---
title: Block Creation
editLink: false
---

# Block Creation
Although block classes can be written manually, there is a very useful WP-CLI command which can be used to create new blocks that can be edited further. This is often much more efficient then writing each block class manually.

The creation of a new block is very simple and can be done in a few steps. The plugin is built to be simple to use and easy to get started with.

The command will create all the necessary files and folders for a new block within the currently active theme directory by default. Please see the the following example command call:

```bash
wp make-block "My New Block"
```

With "My New Block" being the name of the block you would like to create. This will then add a new block directory to the "blocks" directory with the theme. This will be created with a basic file structure and will be ready to be edited and used.

The file structure will look like this:

```
blocks
└── all.php
└── my-new-block-block
    ├── templates
    │   └── block.php
    └── class-my-new-block-block.php
```

The command has no prerequisites other then the existence of an active theme folder. If the active theme does not contain a "blocks" directory, this will be created. An "all.php" file will also be added to the "blocks" directory. This file will handle the inclusion and initialization of block classes. The "all.php" file will look like this:

```php
<?php
/**
 * File to load and initialize blocks.
 *
 * @package My Client's Brand
 */

require_once __DIR__ . '/my-new-block-block/class-my-new-block-block.php';
My_New_Block_Block::init();

```

The all.php file should be required within the theme's functions.php file.

```php
// Load and initialize blocks.
require_once get_template_directory() . '/blocks/all.php';
```

The "blocks" directory will also contain a directory to store all files required for the newly created block. This directory is called "my-new-block" in the example above.

When the command is run to create a second block, another block specific directory will be added to the "blocks" directory and the code required for the inclusion and initialization of the new block will be appended to the "all.php" file.

For example, when the following command is run:

```bash
wp make-block "My Second Block"
```

The previously mentioned file structure will look like this:

```
blocks
└── all.php
└── my-new-block-block
    ├── templates
    │   └── block.php
    └── class-my-new-block-block.php
└── my-second-block-block
    ├── templates
    │   └── block.php
    └── class-my-second-block-block.php
```
