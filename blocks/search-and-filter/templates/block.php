<?php
/**
 * Search and Filter block template.
 *
 * @package Creode Blocks
 */

$block = Creode_Blocks\Helpers::get_block_by_name( 'search-and-filter' );

if ( ! $block ) {
	return;
}

$allowed_inner_blocks = apply_filters(
	'creode_blocks_search_and_filter_allowed_inner_blocks',
	array(
		'core/heading',
		'core/paragraph',
		'core/list',
		'core/buttons',
	)
);
$inner_block_template = apply_filters(
	'creode_blocks_search_and_filter_inner_block_template',
	array(
		array(
			'core/heading',
			array(
				'content' => 'Search and Filter',
			),
		),
		array( 'acf/search-and-filter-form' ),
		array( 'acf/search-and-filter-results' ),
	)
);
?>
<div class="search-and-filter__wrapper <?php echo esc_attr( $block->get_modifier_class_string( 'search-and-filter__wrapper' ) ); ?>">
	<div class="search-and-filter__inner">
		<InnerBlocks
			className="search-and-filter__sections"
			allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
			template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		/>
	</div>
</div>
