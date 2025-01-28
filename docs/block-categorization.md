---
title: Block Categorization
editLink: false
---

# Block Categorization

To avoid confusion in the admin user experience, it is very important that blocks appear within appropriate categories within the WordPress block inserter.

## The default category

This plugin is most commonly used for the development of branded / brand specific blocks. That's to say, blocks that a content editor can provide simple content for, without needing to consider low-level visual design techniques, since stylistic considerations would be made during the initial block development. If this is the case it makes sense to define a default block category which usually relates to the brand conveyed by the block. This is often the name of the current theme or could be something more specific.

The default block category can be defined using the "set_default_block_category" static function of the "Creode_Blocks\Helpers" class. Please see the following code example which can be added to a theme's functions.php file.

```PHP
// Add a brand specific block category.
add_filter(
	'block_categories_all',
	function ( array $categories ) {
		/**
         * The array_unshift function is used to ensure that the category
         * appears at the top of the WordPress block inserter.
         * This ensures that it will be easy to find by the content editor
         * because these blocks will be most commonly used.
         */ 
		array_unshift(
			$categories,
			array(
				'slug'  => 'example-brand',
				'title' => 'Example Brand',
			)
		);

		return $categories;
	}
);

// Set brand specific block category to default.
Creode_Blocks\Helpers::set_default_block_category( 'example-brand' );
```

If this is added before the inclusion of the "all.php" file, blocks initialized within the "all.php" file will appear within the "Example Brand" category, unless blocks explicitly define their own category. This will be discussed in more detail.

::: tip
If different categories should be used for different blocks, one technique is to call the "set_default_block_category" function directly from the "all.php" file. Then call it again to change the category for blocks initialized after that point.
:::

## Category defined by a block class

Where a default category should not be used, a block class can specify it's category. This can be done by defining a "category" function. Please see the following example of a block class that provides this.

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
	protected function category(): string {
		return 'some-other-category';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function template(): string {
		return __DIR__ . '/templates/block.php';
	}
}
```
