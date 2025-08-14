<?php
/**
 * Header block template file.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

?>

<div class="site-header__section site-header__section--desktop-menu">
	<div class="site-header__desktop-menu">
		<?php Helpers::render_blocks( '<!-- wp:template-part {"slug":"desktop-menu"} /-->' ); ?>
	</div>
</div>
