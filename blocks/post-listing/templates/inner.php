<?php
/**
 * Post Listing block template.
 *
 * @package Creode Blocks
 */

$allowed_inner_blocks = array(
	'acf/post-listing-inner-sections',
);
?>

<InnerBlocks
	allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
	class="post-listing__query-inner"
/>
