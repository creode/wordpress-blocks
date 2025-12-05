<?php
/**
 * Child block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Ensure $block is available if rendering is via an AJAX request.
 *
 * @var array Details about the current block.
 */
//phpcs:ignore -- requires auth;
$block = ( empty( $block ) && acf_verify_ajax() && isset( $_REQUEST['block'] ) ) ? json_decode( wp_unslash( $_REQUEST['block'] ), true ) : $block;

/**
 * Get the Block instance for this block type.
 *
 * @var Block The instance for this block type.
 */
$creode_block = Helpers::get_block_by_child_block_name( $block['name'] );

/**
 * Get the Child_Block instance for this block type.
 *
 * @var Child_Block The instance for this block type.
 */
$creode_child_block = Helpers::get_child_block_by_name( $block['name'] );

/**
 * Check if the child block supports colors.
 *
 * @var bool True if the child block supports colors, false otherwise.
 */
$additional_wrapper = ! $is_preview &&
	(
		$creode_child_block->supports['color']['background'] ||
		$creode_child_block->supports['color']['text']
	);
?>

<?php if ( $additional_wrapper ) : ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div <?php echo get_block_wrapper_attributes(); ?>>
<?php endif; ?>

<?php require $creode_child_block->template; ?>

<?php if ( $additional_wrapper ) : ?>
	</div>
<?php endif; ?>
