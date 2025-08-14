<?php
/**
 * Header block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

wp_enqueue_script( 'site_header' );

$inner_block_template = array(
	array( 'acf/site-header-logo' ),
	array( 'acf/site-header-desktop-menu' ),
	array( 'acf/site-header-mobile-menu-toggle' ),
);
?>

<div class="site-header__main">
	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( array() ) ); ?>"
		template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
		orientation="horizontal"
		class="site-header__sections"
	/>
</div>

<div class="site-header__mobile-menu-outer-wrapper">
	<div class="site-header__mobile-menu-wrapper" hidden aria-hidden="true" inert>
		<div class="site-header__mobile-menu">
			<?php Helpers::render_blocks( '<!-- wp:template-part {"slug":"mobile-menu"} /-->' ); ?>
		</div>
	</div>
</div>
