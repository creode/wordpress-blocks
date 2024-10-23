<?php
/**
 * Default Search and Filter results shortcode template.
 *
 * @package Creode Blocks
 */

if ( class_exists( 'Creode_Blocks\Helpers' ) ) {
	$block = Creode_Blocks\Helpers::get_block_by_name( 'search-and-filter' );
	$block->render_results_list( $args, $query );
}
