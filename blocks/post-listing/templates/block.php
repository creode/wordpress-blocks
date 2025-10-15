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

$dynamic_context = array();

if ( $block->get_field( 'sort_by' ) === 'metafield' ) {
	$dynamic_context['creode_blocks_sort_by'] = 'metafield';
	$dynamic_context['sort_meta_key']         = $block->get_field( 'metafield_sort_by' );
	$dynamic_context['sort_meta_order']       = $block->get_field( 'metafield_sort_order' );
}

$allowed_inner_blocks = array(
	'core/query',
);
?>

<?php if ( ! $is_preview && isset( $wp_block ) && isset( $wp_block->parsed_block ) && isset( $wp_block->parsed_block['innerBlocks'] ) ) : ?>
	<div class="post-listing__query-wrapper" id="<?php echo esc_attr( $block->get_unique_id() ); ?>">
		<?php
		Helpers::render_blocks_with_dynamic_context(
			$wp_block->parsed_block['innerBlocks'],
			$dynamic_context
		);
		?>
	</div>
<?php else : ?>
	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $block->get_inner_block_template() ) ); ?>"
		class="post-listing__query-wrapper"
	/>
<?php endif; ?>
