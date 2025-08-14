<?php
/**
 * Mobile Menu block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

wp_enqueue_script( 'mobile_menu' );

$allowed_inner_blocks = array(
	'core/heading',
	'core/paragraph',
	'core/list',
	'core/buttons',
);
$inner_block_template = array(
	array( 'acf/mobile-menu-menu' ),
);
?>

<div class="mobile-menu__wrapper">
	<div class="mobile-menu__toggle-wrapper">
		<button
			type="button"
			role="switch"
			aria-checked="true"
			aria-expanded="true"
			aria-label="Close the menu"
			class="mobile-menu__toggle"
		>
			Open / Close
		</button>
	</div>

	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		class="mobile-menu__inner"
	/>
</div>
