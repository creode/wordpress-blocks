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

$block_id = $block->get_field( 'id' );

$inner_block_template = array(
	array(
		'acf/table-additional-content',
		array(),
		array(
			array(
				'core/heading',
				array(
					'level'   => 2,
					'content' => 'Table',
				),
			),
			array(
				'core/paragraph',
				array(
					'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id porta mauris, at varius eros. Maecenas rutrum vehicula ante, et iaculis metus ultricies id. Morbi vel bibendum tortor, non egestas ipsum. Suspendisse potenti. Donec faucibus interdum lorem, in bibendum elit varius quis. Sed in lectus in sapien bibendum rhoncus.',
				),
			),
		),
	),
	array( 'acf/table-table' ),
	array(
		'acf/table-additional-content',
		array(),
		array(
			array(
				'core/buttons',
				array(),
				array(
					array( 'core/button' ),
				),
			),
		),
	),
);
?>

<div
	class="table__main"
	<?php if ( ! empty( $block_id ) ) : ?>
		id="<?php echo esc_attr( $block_id ); ?>"
	<?php endif; ?>
>
	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		class="table__sections"
	/>
</div>
