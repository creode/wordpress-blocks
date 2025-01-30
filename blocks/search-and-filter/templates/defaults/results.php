<?php
/**
 * Default Search and Filter results shortcode template.
 *
 * @package Creode Blocks
 */

if ( class_exists( 'Creode_Blocks\Helpers' ) ) {
	/**
	 * Search and Filter block class.
	 *
	 * @var Search_And_Filter_Block $block
	 */
	$block = Creode_Blocks\Helpers::get_block_by_name( 'search-and-filter' );
	$block->render_results_list( $args, $query );
}
