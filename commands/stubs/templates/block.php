<?php
/**
 * Example block template file.
 *
 * @package Creode Blocks
 */

/**
 * The block instance.
 *
 * @var BLOCK_CLASS_HERE
 */
$block = Creode_Blocks\Helpers::get_block_by_name( 'BLOCK_NAME_HERE' );

$allowed_inner_blocks = array(
	'core/paragraph',
);
$inner_block_template = array(
	array( 'core/paragraph' ),
);
?>

<?php if ( ! $is_preview ) : ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div <?php echo get_block_wrapper_attributes( array( 'class' => 'block__outer-wrapper' ) ); ?>>
<?php endif; ?>

<div class="block__wrapper">
	<div class="block__inner">
		<InnerBlocks
			allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
			template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
			class="block__blocks"
		/>
	</div>
</div>

<?php if ( ! $is_preview ) : ?>
	</div>
<?php endif; ?>
