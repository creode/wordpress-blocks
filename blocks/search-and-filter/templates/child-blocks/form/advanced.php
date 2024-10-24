<?php
/**
 * Form advanced item block template.
 *
 * @package Creode Blocks
 */

$allowed_inner_blocks = array(
	'search-filter/advanced',
);
$inner_block_template = array(
	array( 'search-filter/advanced' ),
);
?>

<InnerBlocks
	className="search-and-filter__form-item search-and-filter__form-item--advanced"
	allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
	template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
	templateLock="all"
/>
