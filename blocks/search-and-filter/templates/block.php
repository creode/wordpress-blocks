<?php
/**
 * Search and Filter block template.
 *
 * @package Creode Blocks
 */

$allowed_inner_blocks = array(
	'core/heading',
	'core/paragraph',
	'core/list',
);
$inner_block_template = array(
	array(
		'core/heading',
		array(
			'content' => 'Search and Filter',
		),
	),
	array( 'acf/search-and-filter-results' ),
);
?>
<div class="search-and-filter__wrapper">
	<div class="search-and-filter__inner">
		<InnerBlocks
			className="search-and-filter__sections"
			allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
			template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		/>
	</div>
</div>
