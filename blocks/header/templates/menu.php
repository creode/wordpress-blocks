<?php
/**
 * Header menu template file.
 *
 * @package Creode Blocks
 */

/**
 * The block instance.
 *
 * @var Creode_Blocks\Header_Block
 */
$block = Creode_Blocks\Helpers::get_block_by_name( 'creode-header' );

if ( ! $block ) {
	return;
}

$menu_location = $block->get_field( 'menu_location' );
?>

<div class="header__section header__section--menu header__section--desktop-menu" <?php if ( ! is_admin() ) : ?>style="display:none;"<?php endif; ?>>
	<div class="header__menu-toggle-wrapper" hidden aria-hidden>
		<input id="header-menu-toggle" type="checkbox" class="header__menu-toggle" hidden aria-hidden>
		<label for="header-menu-toggle" class="header__menu-toggle-label" aria-haspopup="menu" :aria-expanded="menuExpanded" aria-controls="header-menu">
			Open Menu
		</label>
	</div>
	<div id="header-menu" class="header__menu-wrapper">
		<nav class="header__menu-inner">
			<div class="header__menu-close-button-wrapper" hidden aria-hidden>
				<button type="button" class="header__menu-close-button">
					Close menu
				</button>
			</div>
			<?php $block->render_menu_by_location( ! empty( $menu_location ) ? $menu_location : '' ); ?>
		</nav>
	</div>
</div>
