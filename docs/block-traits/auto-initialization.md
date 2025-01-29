---
title: Block Trait Auto Initialization
editLink: false
---

# Block Trait Auto Initialization

Some traits will auto-initialize when added to a block class. This means that many of the necessary trait functions for adding behaviour to blocks do not need to be called manually. They will be called automatically simply because a block class uses a particular trait.

## How does trait initialization affect the development of blocks?

As some of the traits provided by this plugin can auto-initialize, it is possible to develop block-specific traits within your theme that can also auto-initialize. This is very useful for adding the same functionality to multiple blocks.

Consider the following class:

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

	use Testing_Trait;

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

"Testing_Trait" may be required to perform a setup process when the block initializes. For example it may need to add a field to the block. To do this, "Testing_Trait" must provide an initialization function. The name of this function must be "init_" followed by the name of the trait in lowercase. For "Testing_Trait" this would be "init_testing_trait". This function will be called automatically when the block initializes.

"Testing_Trait" may look as follows:

```php
<?php
/**
 * Example trait.
 *
 * @package My Client's Brand
 */

/**
 * Example trait.
 */
trait Testing_Trait {

	/**
	 * Trait initialization function.
	 */
	protected function init_testing_trait() {
		$this->add_test_field();
	}

	/**
	 * Adds a test field to the block.
	 */
	private function add_test_field() {
		$block_name = $this->name();

		add_filter(
			'block-' . $block_name . '-fields',
			function ( array $fields ) use ( $block_name ) {
				array_push(
					$fields,
					array(
						'key'   => 'field_' . str_replace( '-', '_', $block_name ) . '_test',
						'name'  => 'test',
						'label' => 'Test',
						'type'  => 'text',
					)
				);

				return $fields;
			},
			20
		);
	}
}
```