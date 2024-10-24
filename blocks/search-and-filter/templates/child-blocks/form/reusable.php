<?php
/**
 * Form reusable item block template.
 *
 * @package Creode Blocks
 */

$allowed_inner_blocks = array(
	'search-filter/reusable-field',
);
$inner_block_template = array(
	array( 'search-filter/reusable-field' ),
);
?>

<InnerBlocks
	className="search-and-filter__form-item search-and-filter__form-item--reusable"
	allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
	template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
	templateLock="all"
/>
