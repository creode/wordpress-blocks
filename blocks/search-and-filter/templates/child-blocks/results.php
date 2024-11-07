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
	<p>Results will be shown here.</p>
</div>
