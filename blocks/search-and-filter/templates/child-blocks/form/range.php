<?php
/**
 * Form range item block template.
 *
 * @package Creode Blocks
 */

$allowed_inner_blocks = array(
	'search-filter/range',
);
$inner_block_template = array(
	array( 'search-filter/range' ),
);
?>

<InnerBlocks
	className="search-and-filter__form-item search-and-filter__form-item--range"
	allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
	template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
	templateLock="all"
/>
