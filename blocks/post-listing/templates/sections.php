<?php
/**
 * Post Listing block template.
 *
 * @package Creode Blocks
 */

$allowed_inner_blocks = array(
	'acf/post-listing-inner-sections-section',
);

$inner_block_template = array(
	array( 'acf/post-listing-inner-sections-section' ),
);
?>

<InnerBlocks
	allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
	template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
	class="post-listing__sections"
/>
