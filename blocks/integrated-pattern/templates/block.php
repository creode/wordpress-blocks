<?php
/**
 * Integrated Pattern block template file.
 *
 * @package Creode Blocks
 */

/**
 * The block instance.
 *
 * @var Creode_Blocks\Integrated_Pattern_Block
 */
$block              = Creode_Blocks\Helpers::get_block_by_name( 'integrated-pattern' );
$block_pattern_slug = $block->get_field( 'block_pattern' );

if ( empty( $block_pattern_slug ) ) {
	echo 'Please select a pattern.';

	return;
}

Creode_Blocks\Integrated_Pattern_Block::render_block_pattern( $block_pattern_slug );
