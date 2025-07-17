<?php
/**
 * Post Listing block template.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * The block instance.
 *
 * @var Post_Listing_Block
 */
$block = Helpers::get_block_by_name( 'post-listing' );
?>

<InnerBlocks
	allowedBlocks="<?php echo esc_attr( wp_json_encode( $block->get_allowed_inner_blocks() ) ); ?>"
	template="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
	class="post-listing__section"
/>
