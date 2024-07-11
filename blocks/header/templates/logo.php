<?php
/**
 * Header logo template file.
 *
 * @package Creode Blocks
 */

?>

<div class="header__section header__section--logo">
	<div class="header__logo-wrapper">
		<img
			src="<?php echo esc_url( apply_filters( 'header_logo_src', get_stylesheet_directory_uri() ) ); ?>/images/logo.svg"
			alt="<?php echo esc_html( apply_filters( 'header_logo_alt', get_bloginfo( 'name' ) ) ); ?>"
		/>
	</div>
</div>
