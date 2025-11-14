<?php
/**
 * Table block template file.
 *
 * @package Creode Blocks
 */

$allowed_inner_blocks = array(
	'core/heading',
	'core/paragraph',
	'core/list',
	'core/buttons',
);
?>

<div class="table__section table__section--additional-content">
	<InnerBlocks
		allowedBlocks="<?php echo esc_attr( wp_json_encode( $allowed_inner_blocks ) ); ?>"
		class="table__additional-content"
	/>
</div>
