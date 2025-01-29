---
title: Block Supports
editLink: false
---

# Block Supports

Block classes can specify a supports array to declare the core WordPress block customization options that they  support.

To utilize this functionality a block class must specify a "supports" function. This should return a supports array. Please see the following documentation for more detail about the required structure of this array:
 - (https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/)
 - (https://developer.wordpress.org/block-editor/getting-started/fundamentals/block-json/#using-block-supports-to-enable-settings-and-styles)
 - (https://www.advancedcustomfields.com/resources/extending-acf-blocks-with-block-supports/)

The most common supports are for color and background color. These are often used together to ensure that when a block's background color is changed, it's text color can also be changed to ensure that text contrasts the background.

::: tip
To avoid contrast problems, it is useful to style typographic elements (heading, paragraphs etc.) to inherit their color property values from parent elements. This is because the color support causes the color CSS rule to be applied to a block's outer element.
:::

## An example

The following example demonstrates usage of the color and background color supports. It also disables the ACF mode property to allow switching between edit and preview modes.

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

	/**
	 * {@inheritdoc}
	 */
	protected function supports(): array {
		return array(
			'mode'  => false,
			'color' => array(
				'text'       => true,
				'background' => true,
			),
		);
	}
}
```

::: tip
In the case of branded blocks aimed at content editors who are required to supply only simple content without needing to consider low-level visual design techniques, supports should be used sparingly. Blocks should not require the use of supports for basic rendering. These should be treated as stylistic enhancements. A good use case is that a background color of one block could be changed to ensure good contrast with an adjacent block.
:::
