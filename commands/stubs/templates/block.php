<?php
/**
 * Example block template file.
 *
 * @package Creode Blocks
 */

/**
 * Load your block object.
 * Replace "BLOCK_NAME_HERE" with your block name.
 * Delete the following lines if not needed.
 */
$block = Creode_Blocks\Helpers::get_block_by_name( 'BLOCK_NAME_HERE' );

if ( ! $block ) {
	echo 'Example block output.';

	return;
}

$allowed_inner_blocks = array(
	'core/paragraph',
);
$inner_block_template = array(
	array( 'core/paragraph' ),
);
?>

<?php if ( ! $is_preview ) : ?>
	<div <?php echo get_block_wrapper_attributes( array( 'class' => 'block__outer-wrapper' ) ); ?>>
<?php endif; ?>

<div class="block__wrapper">

	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
	/>

</div>

<?php if ( ! $is_preview ) : ?>
	</div>
<?php endif; ?>
