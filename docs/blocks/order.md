---
title: Order Of Blocks
editLink: false
---

# Order Of Blocks
The order that blocks will appear within the WordPress block inserter depends on the order that they are initialized. Based on the previous example the "all.php" file will look like this:

```php
<?php
/**
 * File to load and initialize blocks.
 *
 * @package My Client's Brand
 */

require_once __DIR__ . '/my-new-block-block/class-my-new-block-block.php';
My_New_Block_Block::init();

require_once __DIR__ . '/my-second-block-block/class-my-second-block-block.php';
My_Second_Block_Block::init();

```

Due to this file, the block "My Second Block" will appear after the "My New Block" within the WordPress block inserter. If we would like the block "My Second Block" to appear before "My New Block", we just need to re-arrange this file to the following:

```php
<?php
/**
 * File to load and initialize blocks.
 *
 * @package My Client's Brand
 */

require_once __DIR__ . '/my-second-block-block/class-my-second-block-block.php';
My_Second_Block_Block::init();

require_once __DIR__ . '/my-new-block-block/class-my-new-block-block.php';
My_New_Block_Block::init();

```