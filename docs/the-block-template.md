---
title: The Block Template
editLink: false
---

# The Block Template

Each block class must specify a "template" function. This must return a full path to a file that will be used to render the block. In the case of the WP-CLI "make-block" command this will be a file called "block.php".

## Block instance access

The block class instance can be retrieved within the template file using the "get_block_by_name" static function of the "Creode_Blocks\Helpers" class.

```php
/**
 * The block instance.
 *
 * @var My_New_Block_Block
 */
$block = Creode_Blocks\Helpers::get_block_by_name( 'my-new-block-block' );
```

::: info
The reason that a helper function should be used here (as opposed to accessing the $instance property directly or via a public block class function) is due to the fact that block classes can be extended. Therefore in the example above there is no guarantee that the object retrieved is a direct instance of My_New_Block_Block or the value stored within the My_New_Block_Block::$instance property. The object could be an instance of a class which extends My_New_Block_Block but uses the same name.
:::

This can be vary useful for calling public functions that the class provides. The most common is the "get_field" function which is available on all block classes.

## Get field

Each block class has a public "get_field" function for retrieving a field value set against the block. Please see the following example:

```php
$example_field = $block->get_field( 'example_field' );
```

## Wrapper attributes

The "get_block_wrapper_attributes" function can be used on a block's most outer element to retrieve the HTML attributes required for stylistic rendering. The stylistic rendering options should be specified as block supports. The element should only be output within front-end renderings since the WordPress editor will handle these attributes.

```php
<?php if ( ! $is_preview ) : ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div <?php echo get_block_wrapper_attributes( array( 'class' => 'my-new-block__outer-wrapper' ) ); ?>>
<?php endif; ?>
```

Please see the following for further information:
 - (https://developer.wordpress.org/reference/functions/get_block_wrapper_attributes/)
 - (https://www.advancedcustomfields.com/resources/acf-blocks-using-get_block_wrapper_attributes/)

## Inner blocks

Each block template can contain an InnerBlocks element which can be used for nesting other blocks. This should conform to the WordPress InnerBlocks element conventions, please see the following for more detailed usage:

 - (https://github.com/WordPress/gutenberg/blob/trunk/packages/block-editor/src/components/inner-blocks/README.md)
 - (https://developer.wordpress.org/block-editor/how-to-guides/block-tutorial/nested-blocks-inner-blocks/)
 - (https://www.advancedcustomfields.com/resources/acf-blocks-using-innerblocks-and-parent-child-relationships/)

The most commonly used attributes for the InnerBlocks element are:

 - allowedBlocks (To ensure that inappropriate blocks are not accidentally added by content editors and to guide to admin user experience.)
 - template (To define the nested block structure that should be inserted when this block is added from the WordPress block inserter.)
 - templateLock (To ensure that often complex and fragile template nested block structures and not accidentally affected by content editors. Also to unlock nested block structures in child blocks. These will be discussed in more detail.)
 - class (To define an HTML class for the container div which will be used within the editor and on front-end renderings. This can then be targeted with CSS).

## A complete example

```php
<?php
/**
 * My New Block block template file.
 *
 * @package My Client's Brand
 */

/**
 * The block instance.
 *
 * @var My_New_Block_Block
 */
$block = Creode_Blocks\Helpers::get_block_by_name( 'my-new-block-block' );

$example_field        = $block->get_field( 'example_field' );
$allowed_inner_blocks = array(
	'core/heading',
	'core/paragraph',
);
$inner_block_template = array(
	array(
		'core/heading',
		array(
			'level'   => 2,
			'content' => 'My New Block',
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

<?php if ( ! $is_preview ) : ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div <?php echo get_block_wrapper_attributes( array( 'class' => 'my-new-block__outer-wrapper' ) ); ?>>
<?php endif; ?>

<div class="my-new-block__wrapper">
	<div class="my-new-block__inner">
		<InnerBlocks
			allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
			template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
			class="my-new-block__inner-blocks"
		/>
	</div>
</div>

<?php if ( ! $is_preview ) : ?>
	</div>
<?php endif; ?>
```