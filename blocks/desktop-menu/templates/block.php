<?php
/**
 * Desktop Menu block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * The block instance.
 *
 * @var Desktop_Menu_Block
 */
$block = Helpers::get_block_by_name( 'desktop-menu' );

$menu_location = $block->get_field( 'menu_location' );
?>

<div class="desktop-menu__wrapper">
	<?php if ( empty( $menu_location ) ) : ?>
		Please select a menu.
	<?php else : ?>
		<?php $block->render_menu_by_location( $menu_location, $block->get_menu_render_arguments() ); ?>
	<?php endif; ?>
</div>
