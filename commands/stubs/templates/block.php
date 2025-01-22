<?php
/**
 * :BLOCK_LABEL block template file.
 *
 * @package :THEME_NAME
 */

/**
 * The block instance.
 *
 * @var :BLOCK_CLASS
 */
$block = Creode_Blocks\Helpers::get_block_by_name( ':BLOCK_NAME' );

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
			'content' => ':BLOCK_LABEL',
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
	<div <?php echo get_block_wrapper_attributes( array( 'class' => ':BLOCK_HTML_BASE_CLASS__outer-wrapper' ) ); ?>>
<?php endif; ?>

<div class=":BLOCK_HTML_BASE_CLASS__wrapper">
	<div class=":BLOCK_HTML_BASE_CLASS__inner">
		<InnerBlocks
			allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
			template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
			class=":BLOCK_HTML_BASE_CLASS__inner-blocks"
		/>
	</div>
</div>

<?php if ( ! $is_preview ) : ?>
	</div>
<?php endif; ?>
