---
title: The Block Class
editLink: false
---

# The Block Class

This plugin does include a WordPress CLI command to generate a new block definition within a theme. However it is very important to understand the fundamentals of block definition and development. It may be beneficial to create a practice block manually before using the CLI command for blocks intended for production.

## The key concept

Each block is defined as a new PHP class, each block class should be an extension of the Creode_Blocks\Block abstract class. Each block class must contain functions for returning information about the block, e.g. the block label.

## A block class

Each block class must have the following required functions:
 - "name" (must return a meaningful block name, this should be a lowercase a hyphen separated string)
 - "label" (must return text to label the block within the admin UI)
 - "template" (must return a complete path to a php file that will be used to render the block)

Each block should also contain a protected static $instance property. This will be used to store a single instance of the class. This instance can be retrieved globally using a helper function.

### Your first block

Please see the following example of the most basic block class:

```php
<?php
/**
 * Your First block class.
 *
 * @package My Client's Brand
 */

use Creode_Blocks\Block;

/**
 * Your First block class.
 */
class Your_First_Block extends Block {

	/**
	 * Singleton instance of this class.
	 *
	 * @var Your_First_Block|null
	 */
	protected static $instance = null;

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'your-first-block';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'Your First Block';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function template(): string {
		return __DIR__ . '/templates/block.php';
	}
}
```

Each block class must be initialized before it can be selected from the WordPress block inserter. To initialize a block, first ensure that the file containing the block class is included within the WordPress execution. To do this add the following code or equivalent to an appropriate WordPress file. This could be a theme functions.php file or a plugin entry point file. The following code assumes that the file containing the block class is called class-your-first-block.php and is stored within a directory called "your-first-block" which is stored within a directory called "blocks" relative to the file that the line will be added to.

```php
require_once __DIR__ . '/blocks/your-first-block/class-your-first-block.php';
```

Once the file has been executed, the class will exist globally within memory. The class must then be initialized before it can be selected from the WordPress block inserter. To initialize a block class, call it's static function "init". Please see the following example.

```php
Your_First_Block::init();
```

The block will then be available within the WordPress block inserter.
