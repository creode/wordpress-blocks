<?php
/**
 * Defualt block wrapper template.
 *
 * @package Creode Blocks
 */

/**
 * Ensure $block is available if rendering is via an AJAX request.
 *
 * @var array Details about the current block.
 */
//phpcs:ignore -- requires auth;
$block = ( empty( $block ) && acf_verify_ajax() && isset( $_REQUEST['block'] ) ) ? json_decode( wp_unslash( $_REQUEST['block'] ), true ) : $block;

/**
 * If block is still not available, do nothing.
 */
if ( empty( $block ) ) {
	return;
}

/**
 * If block name is not available, do nothing.
 */
if ( empty( $block['name'] ) ) {
	return;
}

/**
 * Assign the block's name to a variable and remove the prefix.
 *
 * @var string The block's name.
 */
$block_name = str_replace( 'acf/', '', $block['name'] );

/**
 * Retrieve the Creode_Blocks\Block instance for this block type.
 *
 * @var Creode_Blocks\Block The instance for this block type.
 */
$creode_block = Creode_Blocks\Helpers::get_block_by_name( $block_name );

/**
 * If Creode_Blocks\Block instance cannot be found, do nothing.
 */
if ( ! $creode_block ) {
	return;
}
?>

<?php if ( ! $is_preview ) : ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div <?php echo get_block_wrapper_attributes( array( 'class' => $block_name . '__outer-wrapper' ) ); ?>>
<?php endif; ?>

	<div class="<?php echo esc_attr( $block_name ); ?>__wrapper <?php echo esc_attr( $creode_block->get_modifier_class_string( $block_name . '__wrapper' ) ); ?>">
		<div class="<?php echo esc_attr( $block_name ); ?>__inner">
			<?php require $creode_block->get_template(); ?>
		</div>
	</div>

<?php if ( ! $is_preview ) : ?>
	</div>
<?php endif; ?>
