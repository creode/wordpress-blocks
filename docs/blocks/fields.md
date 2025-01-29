---
title: Block Fields
editLink: false
---

# Block Fields

Each block can specify a series of Advanced Custom Fields whose values can be retrieved within the a block template file.

To utilize this functionality a block class must specify a "fields" function. This function must return an ACF fields array.

Within the following documentation, the ACF fields array is the value of the "fields" property of the array supplied to the "acf_add_local_field_group" function. (https://www.advancedcustomfields.com/resources/register-fields-via-php/)

Once specified these fields will appear in the sidebar whenever the block is selected within the WordPress editor.

## An example

The following example demonstrates definition of the most common field types.

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
	protected function fields(): array {
		return array(
			array(
				'key'           => 'field_your_first_block_image',
				'label'         => 'Image',
				'name'          => 'image',
				'type'          => 'image',
				'return_format' => 'id',
			),
			array(
				'key'     => 'field_your_first_block_image_format',
				'label'   => 'Image Format',
				'name'    => 'image_format',
				'type'    => 'select',
				'choices' => array(
					''  => 'None',
					'1' => 'Format 1',
					'2' => 'Format 2',
					'3' => 'Format 3',
				),
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function template(): string {
		return __DIR__ . '/templates/block.php';
	}
}
```