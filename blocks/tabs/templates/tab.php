<?php
/**
 * Tabs block template file.
 *
 * @package Creode Blocks
 */

$allowed_inner_blocks = array(
	'core/heading',
);
$inner_block_template = array(
	array(
		'core/heading',
		array(
			'level'   => 3,
			'content' => 'Tab',
		),
	),
);
?>

<?php if ( ! $is_preview ) : ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div <?php echo get_block_wrapper_attributes( array( 'class' => 'tabs__tab-outer-wrapper' ) ); ?>>
<?php endif; ?>

<div class="tabs__tab-wrapper">
	<button class="tabs__tab">
		<InnerBlocks
			allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
			template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
			class="tabs__tab-inner"
		/>
	</button>
</div>

<?php if ( ! $is_preview ) : ?>
	</div>
<?php endif; ?>
