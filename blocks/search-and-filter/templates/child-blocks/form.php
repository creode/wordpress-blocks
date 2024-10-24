<?php
/**
 * Form child block template.
 *
 * @package Creode Blocks
 */

$inner_block_template = array(
	array( 'acf/search-and-filter-form-search' ),
);
?>
<div class="search-and-filter__section search-and-filter__section--form">
	<div class="search-and-filter__form">
		<InnerBlocks
			className="search-and-filter__form-items"
			allowedBlocks="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
			template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
			orientation="<?php echo esc_attr( apply_filters( 'creode_blocks_search_and_filter_form_item_orientation_horizontal', false ) ? 'horizontal' : 'vertical' ); ?>"
		/>
	</div>
</div>
