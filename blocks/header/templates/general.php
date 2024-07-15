<?php
/**
 * Header general template file.
 *
 * @package Creode Blocks
 */

?>

<div class="header__section header__section--general">
	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( array( 'core/paragraph' ) ) ); ?>"
	/>
</div>