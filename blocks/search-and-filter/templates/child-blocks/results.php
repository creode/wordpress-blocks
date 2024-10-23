<?php
/**
 * Results child block template.
 *
 * @package Creode Blocks
 */

$query_id = get_field( 'query_id' );

if ( empty( $query_id ) ) {
	echo 'Please choose a query.';
	return;
}
?>

<div class="search-and-filter__section search-and-filter__section--results">
	<?php echo do_shortcode( '[searchandfilter query="' . $query_id . '" action="show-results"]' ); ?>
</div>
