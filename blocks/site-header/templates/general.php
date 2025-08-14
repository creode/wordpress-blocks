<?php
/**
 * Header block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Header block instance.
 *
 * @var Header_Block
*/
$block = Helpers::get_block_by_name( 'site-header' );

$inner_block_template = array(
	array(
		'core/paragraph',
		array(
			'content' => 'Place any content here.',
		),
	),
);
?>

<div class="site-header__section site-header__section--general site-header__section--device-visibility-<?php echo esc_attr( $block->get_field( 'device_visibility' ) ); ?>">
	<InnerBlocks
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		class="site-header__general"
	/>
</div>