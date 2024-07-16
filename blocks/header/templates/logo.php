<?php
/**
 * Header logo template file.
 *
 * @package Creode Blocks
 */

?>

<div class="header__section header__section--logo">
	<div class="header__logo-wrapper">
		<a href="<?php echo esc_url( is_admin() ? '#' : apply_filters( 'header_logo_href', get_home_url() ) ); ?>">
			<img
				src="<?php echo esc_url( apply_filters( 'header_logo_src', get_stylesheet_directory_uri() ) ); ?>/images/logo.svg"
				alt="<?php echo esc_html( apply_filters( 'header_logo_alt', get_bloginfo( 'name' ) ) ); ?>"
			/>
		</a>
	</div>
</div>
