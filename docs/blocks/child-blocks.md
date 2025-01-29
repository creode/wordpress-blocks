---
title: Child Blocks
editLink: false
---

# Child Blocks

So far we have covered everything involved with basic block development. However, blocks often require complex markup structures with multiple InnerBlocks elements. For example, let's say that we are attempting to develop a block called "my-new-block-block" that contains two sections (side by side on desktop devices). Each section can then contain headings and paragraphs. Ideally for maximum versatility the headings and paragraphs should be implemented using WordPress core heading and paragraph blocks. Since the block requires two sections where the core blocks can be added using InnerBlocks elements, it is not possible to achieve this using a single block, because WordPress cannot support multiple InnerBlocks elements for any single block. However, the use of child blocks allows for this.

## What are child blocks

These are blocks that are only allowed to be added to the InnerBlocks element of one particular block, it's parent. These will not appear within the WordPress block inserter unless their parent block is selected. Each child block can also contain an InnerBlocks element as per their parent, therefore they can have their own child blocks. This means that a complex ancestral hierarchy can be defined for each block. Child blocks can be included as part of an InnerBlocks element's template attribute array and template locking can prevent child blocks from being removed from their ancestral hierarchy.

## Why are child blocks needed

Unfortunately WordPress cannot support multiple InnerBlocks elements for a single block. To understand this, let's take a look at the markup structure that will be added to a post's content field when the previously mentioned "My New Block" block is added to a post.

```html
<!-- wp:acf/my-new-block-block {"name":"acf/my-new-block-block","data":{},"mode":"preview"} -->
    <!-- wp:heading -->
        <h2 class="wp-block-heading">My New Block</h2>
    <!-- /wp:heading -->
    <!-- wp:paragraph -->
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id porta mauris, at varius eros. Maecenas rutrum vehicula ante, et iaculis metus ultricies id. Morbi vel bibendum tortor, non egestas ipsum. Suspendisse potenti. Donec faucibus interdum lorem, in bibendum elit varius quis. Sed in lectus in sapien bibendum rhoncus.</p>
    <!-- /wp:paragraph -->
<!-- /wp:acf/my-new-block-block -->
```

WordPress uses an html structure with comment tags to define it's blocks. In the example above, the following line defines the start of a block:

```html
<!-- wp:acf/my-new-block-block {"name":"acf/my-new-block-block","data":{},"mode":"preview"} -->
```

This line defines the end of a block:

```html
<!-- /wp:acf/my-new-block-block -->
```

Everything in between these two lines defines the content of the InnerBlocks element. Therefore there would be nowhere to store the content of another InnerBlocks element.

## How child blocks solve this problem

If multiple InnerBlocks elements are needed, multiple child blocks can be defined. Each child block can contain an InnerBlocks element. The "allowedBlocks" attribute of the top-level block's InnerBlocks element could then be provided as an empty array. This means that no other blocks other than child blocks can be added. References to child blocks could then be included within the "template" attribute array. The InnerBlocks element could be even be template locked to prevent changing the important block structure.

## How to define child blocks

For a block to define child blocks, the block class must have a "child_blocks" function. This function must return an array containing instances of the "Creode_Blocks\Child_Block" class. This class can be instantiated with the following arguments which relate to the child block:

 - name
    - This should identify the child block.
    - This should be lowercase and hyphen separated.
    - The parent block's name will be prepended to this value to ensure that blocks are correctly contextualized. Using the example above, it is not necessary to provide a context specific name such as "my-new-block-block-section", only the name "section" is required. The final block name will be then the converted to the contextualized form of "my-new-block-block-section".
 - label
    - This is the value displayed to the admin user within the WordPress editor.
    - No additional processing of this value is performed, therefore it may be necessary to provide a contextualized term, such as "My New Block Section". This is to allow for maximum flexibility.
 - fields
    - An ACF fields array specific to the child block.
    - Please see [Block Fields](fields) for details about this format.
 - template
    - A complete path to a php file that will be used to render the child block.
 - child_blocks (Optional)
    - An array of "Creode_Blocks\Child_Block" instances.
    - Useful for creating complex block structures.
 - icon (Optional)
    - An icon from dashicons or an inline SVG.
 - supports (Optional)
    - A block supports array.
    - Please see [Block Supports](supports) for details about this format.

## A complete example

Please see below a block class which defines a "child_blocks" function.

```php
<?php
/**
 * My New Block block class.
 *
 * @package My Client's Brand
 */

use Creode_Blocks\Block;
use Creode_Blocks\Child_Block;

/**
 * My New Block block class.
 */
class My_New_Block_Block extends Block {

	/**
	 * Singleton instance of this class.
	 *
	 * @var My_New_Block_Block|null
	 */
	protected static $instance = null;

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'my-new-block-block';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'My New Block';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function child_blocks(): array {
		return array(
			new Child_Block(
				'section',
				'My New Block Section',
				array(),
				__DIR__ . '/templates/section.php'
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

Given this example, the "/templates/block.php" file may be as follows:

```php
<?php
/**
 * My New Block block template file.
 *
 * @package My Client's Brand
 */

$inner_block_template = array(
	array( 'acf/my-new-block-block-section' ),
	array( 'acf/my-new-block-block-section' ),
);
?>

<div class="my-new-block__wrapper">
	<div class="my-new-block__inner">
		<InnerBlocks
			allowedBlocks="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
			template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
			templateLock="all"
			class="my-new-block__sections"
		/>
	</div>
</div>
```

The "/templates/section.php" file may be as follows:

```php
<?php
/**
 * My New Block block template file.
 *
 * @package My Client's Brand
 */

$allowed_inner_blocks = array(
	'core/heading',
	'core/paragraph',
);
$inner_block_template = array(
	array(
		'core/heading',
		array(
			'level'   => 2,
			'content' => 'My New Block Section',
		),
	),
	array(
		'core/paragraph',
		array(
			'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id porta mauris, at varius eros. Maecenas rutrum vehicula ante, et iaculis metus ultricies id. Morbi vel bibendum tortor, non egestas ipsum. Suspendisse potenti. Donec faucibus interdum lorem, in bibendum elit varius quis. Sed in lectus in sapien bibendum rhoncus.',
		),
	),
);
?>

<div class="my-new-block__section">
	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		templateLock="false"
		class="my-new-block__section-content"
	/>
</div>
```

When inserted from the WordPress block inserter, the stored markup would be as follows:

```html
<!-- wp:acf/my-new-block-block {"name":"acf/my-new-block-block","data":{},"mode":"preview"} -->
	<!-- wp:acf/my-new-block-block-section {"name":"acf/my-new-block-block-section","data":{},"mode":"preview" -->
		<!-- wp:heading -->
			<h2 class="wp-block-heading">My New Block Section</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph -->
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id porta mauris, at varius eros. Maecenas rutrum vehicula ante, et iaculis metus ultricies id. Morbi vel bibendum tortor, non egestas ipsum. Suspendisse potenti. Donec faucibus interdum lorem, in bibendum elit varius quis. Sed in lectus in sapien bibendum rhoncus.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:acf/my-new-block-block-section -->
	<!-- wp:acf/my-new-block-block-section {"name":"acf/my-new-block-block-section","data":{},"mode":"preview"} -->
		<!-- wp:heading -->
			<h2 class="wp-block-heading">My New Block Section</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph -->
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id porta mauris, at varius eros. Maecenas rutrum vehicula ante, et iaculis metus ultricies id. Morbi vel bibendum tortor, non egestas ipsum. Suspendisse potenti. Donec faucibus interdum lorem, in bibendum elit varius quis. Sed in lectus in sapien bibendum rhoncus.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:acf/my-new-block-block-section -->
<!-- /wp:acf/my-new-block-block -->
```

This strcuture would allow headings and paragraphs in both sections to be edited using available WordPress editor tools.

The final HTML would be as follows:

```html
<div class="my-new-block__wrapper">
	<div class="my-new-block__inner">
		<div class="my-new-block__sections">
			<div class="my-new-block__section">
				<div class="my-new-block__section-content">
					<h2 class="wp-block-heading">My New Block Section</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id porta mauris, at varius eros. Maecenas rutrum vehicula ante, et iaculis metus ultricies id. Morbi vel bibendum tortor, non egestas ipsum. Suspendisse potenti. Donec faucibus interdum lorem, in bibendum elit varius quis. Sed in lectus in sapien bibendum rhoncus.</p>
				</div>
			</div>
			<div class="my-new-block__section">
				<div class="my-new-block__section-content">
					<h2 class="wp-block-heading">My New Block Section</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id porta mauris, at varius eros. Maecenas rutrum vehicula ante, et iaculis metus ultricies id. Morbi vel bibendum tortor, non egestas ipsum. Suspendisse potenti. Donec faucibus interdum lorem, in bibendum elit varius quis. Sed in lectus in sapien bibendum rhoncus.</p>
				</div>
			</div>
		</div>
	</div>
</div>
```