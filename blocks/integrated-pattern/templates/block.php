<?php
/**
 * Integrated Pattern block template file.
 *
 * @package Creode Blocks
 */

$block_pattern_slug = get_field( 'block_pattern' );

if ( empty( $block_pattern_slug ) ) {
	echo 'Please select a pattern.';

	return;
}

Creode_Blocks\Integrated_Pattern_Block::render_block_pattern( $block_pattern_slug );
