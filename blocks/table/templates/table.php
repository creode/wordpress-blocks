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

$modifier_classes = array();

$device_visibility = $block->get_field( 'device_visibility' );
if ( ! empty( $device_visibility ) ) {
	$modifier_classes[] = 'device-visibility-' . $device_visibility;
}

$modifier_classes = array_map(
	function ( $modifier_class ) {
		return 'table__section--' . $modifier_class;
	},
	$modifier_classes
);

$inner_block_template = array(
	array( 'acf/table-table-row' ),
	array( 'acf/table-table-row' ),
	array( 'acf/table-table-row' ),
);
?>

<div class="table__section table__section--table <?php echo esc_attr( implode( ' ', $modifier_classes ) ); ?>">
	<div class="table__table-outer-wrapper">
		<div class="table__table-wrapper">
			<?php if ( $is_preview ) : ?>
				<InnerBlocks
					allowedBlocks="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
					template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
					class="table__table"
				/>
			<?php else : ?>
				<table class="table__table">
					<?php
						// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo $content;
					?>
				</table>
			<?php endif; ?>
		</div>
	</div>
</div>
