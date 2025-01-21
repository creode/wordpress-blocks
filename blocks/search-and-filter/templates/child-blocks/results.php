<?php
/**
 * Results child block template.
 *
 * @package Creode Blocks
 */

/**
 * The block instance.
 *
 * @var Creode_Blocks\Search_And_Filter_Block
 */
$block    = Creode_Blocks\Helpers::get_block_by_name( 'search-and-filter' );
$query_id = $block->get_field( 'query_id' );

if ( empty( $query_id ) ) {
	echo 'Please choose a query.';
	return;
}
?>

<div class="search-and-filter__section search-and-filter__section--results">
	<?php if ( $is_preview ) : ?>
		<p>Search Results will be displayed here.</p>
		<?php return; ?>
	<?php endif; ?>

	<?php echo do_shortcode( '[searchandfilter query="' . $query_id . '" action="show-results"]' ); ?>
</div>
