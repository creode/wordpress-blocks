<?php
/**
 * Mobile Menu block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * The block instance.
 *
 * @var Mobile_Menu_Block
 */
$block = Helpers::get_block_by_name( 'mobile-menu' );

$menu_location = $block->get_field( 'menu_location' );
?>

<div class="mobile-menu__menu-wrapper">
	<?php if ( empty( $menu_location ) ) : ?>
		Please select a menu.
	<?php else : ?>
		<?php $block->render_menu_by_location( $menu_location ); ?>
	<?php endif; ?>
</div>
