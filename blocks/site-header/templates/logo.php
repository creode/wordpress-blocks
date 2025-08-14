<?php
/**
 * Header block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

?>

<div class="site-header__section site-header__section--logo">
	<div class="site-header__logo">
		<a href="<?php echo esc_attr( get_home_url() ); ?>">
			<img
				src="<?php echo esc_attr( get_stylesheet_directory_uri() ); ?>/images/logo.svg"
				alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
			/>
		</a>
	</div>
</div>
