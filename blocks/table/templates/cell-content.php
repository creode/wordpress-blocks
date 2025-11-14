<?php
/**
 * Table block template file.
 *
 * @package Creode Blocks
 */

/**
 * The block instance.
 *
 * @var Table_Block
 */
$block = Creode_Blocks\Helpers::get_block_by_name( 'table' );

$modifier_classes = apply_filters( 'creode_blocks_table_cell_content_modifier_classes', array() );

$modifier_classes = array_map(
	function ( $modifier_class ) {
		return 'table__table-cell-content--' . $modifier_class;
	},
	$modifier_classes
);

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

<div class="table__table-cell-content <?php echo esc_attr( implode( ' ', $modifier_classes ) ); ?>">
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
