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

$modifier_classes = apply_filters( 'creode_blocks_table_row_modifier_classes', array() );

$modifier_classes = array_map(
	function ( $modifier_class ) {
		return 'table__table-row--' . $modifier_class;
	},
	$modifier_classes
);

$inner_block_template = array(
	array( 'acf/table-table-row-cell' ),
	array( 'acf/table-table-row-cell' ),
	array( 'acf/table-table-row-cell' ),
);
?>

<?php if ( $is_preview ) : ?>
	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		orientation="horizontal"
		class="table__table-row <?php echo esc_attr( implode( ' ', $modifier_classes ) ); ?>"
	/>
<?php else : ?>
	<tr class="table__table-row <?php echo esc_attr( implode( ' ', $modifier_classes ) ); ?>">
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $content;
		?>
	</tr>
<?php endif; ?>
