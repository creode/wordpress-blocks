<?php
/**
 * Header menu template file.
 *
 * @package Creode Blocks
 */

$menu_id = get_field( 'menu_id' );
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
			<?php if ( $menu_id ) : ?>
				<?php
					wp_nav_menu(
						array(
							'container' => '',
							'menu'      => $menu_id,
						)
					);
				?>
			<?php endif; ?>
		</nav>
	</div>
</div>
