<?php
/**
 * Search and Filter results list template.
 *
 * @package Creode Blocks
 */

?>

<?php if ( $query->have_posts() ) : ?>
	<div class="search-and-filter__results">
		<?php while ( $query->have_posts() ) : ?>
			<?php $query->the_post(); ?>
			<div class="search-and-filter__result">
				<?php Creode_Blocks\Search_And_Filter_Block::render_block_pattern( $pattern ); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php else : ?>
	<?php echo wp_kses_post( apply_filters( 'creode_blocks_search_and_filter_results_list_empty_message', '<p>No Results found.</p>', $args, $query ) ); ?>
<?php endif; ?>

<?php wp_reset_postdata(); ?>

<?php if ( ! $disable_pagination && 1 < $query->max_num_pages && 'default' === $pagination_type ) : ?>
	<div class="search-and-filter__pagination">
		<?php
			echo wp_kses_post(
				paginate_links(
					array(
						'total' => $query->max_num_pages,
					)
				)
			);
		?>
	</div>
<?php endif; ?>
