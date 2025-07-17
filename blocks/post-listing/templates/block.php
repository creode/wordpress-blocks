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

$allowed_inner_blocks = array(
	'core/query',
);
?>

<InnerBlocks
	allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
	template="<?php echo esc_attr( wp_json_encode( $block->get_inner_block_template() ) ); ?>"
	templateLock="all"
	class="post-listing__query-wrapper"
/>
