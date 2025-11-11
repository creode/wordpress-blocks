<?php
/**
 * Table block template file.
 *
 * @package Sovereign Health Care
 */

/**
 * The block instance.
 *
 * @var Table_Block
 */
$block = Creode_Blocks\Helpers::get_block_by_name( 'table' );

$modifier_classes = array();

$style = $block->get_field( 'style' );
if ( ! empty( $style ) ) {
	$modifier_classes[] = 'style-' . $style;
}

$curved_corners = $block->get_field( 'curved_corners' );
if ( ! empty( $curved_corners ) ) {
	foreach ( $curved_corners as $corner ) {
		$modifier_classes[] = 'curved-corners-' . $corner;
	}
}

$modifier_classes = array_map(
	function ( $modifier_class ) {
		return 'table__table-cell-content--' . $modifier_class;
	},
	$modifier_classes
);

$icon       = $block->get_icon_svg( 'table', false );
$icon_color = $block->get_field( 'icon_color' );

$allowed_inner_blocks = array(
	'core/paragraph',
);
$inner_block_template = array(
	array(
		'core/paragraph',
		array(
			'content' => 'Table cell content.',
		),
	),
);
?>

<?php if ( ! $is_preview ) : ?>
	<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div <?php echo get_block_wrapper_attributes( array( 'class' => 'table__table-cell-content-outer' ) ); ?>>
<?php endif; ?>

<div
	class="table__table-cell-content <?php echo esc_attr( implode( ' ', $modifier_classes ) ); ?>"
	<?php // phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace ?>
	style="<?php if ( ! empty( $icon_color ) ) : ?>--icon-color: <?php echo esc_attr( $block->get_color_code_by_slug( $icon_color ) ); ?>;<?php endif; ?>"
>

	<?php if ( ! empty( $icon ) ) : ?>
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo strip_tags( $icon, '<div><svg><path>' );
		?>
	<?php endif; ?>

	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		templateLock="false"
		class="table__table-cell-content-inner"
	/>
</div>

<?php if ( ! $is_preview ) : ?>
	</div>
<?php endif; ?>
