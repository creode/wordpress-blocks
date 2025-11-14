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

$colspan = $block->get_field( 'colspan' );

$inner_block_template = array(
	array( 'acf/table-table-row-cell-cell-content' ),
);
?>

<?php if ( $is_preview ) : ?>
	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		templateLock="all"
		class="table__table-cell"
	/>
<?php else : ?>
	<td
		class="table__table-cell"
		<?php if ( ! empty( $colspan ) ) : ?>
			colspan="<?php echo esc_attr( $colspan ); ?>"
		<?php endif; ?>
	>
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $content;
		?>
	</td>
<?php endif; ?>
