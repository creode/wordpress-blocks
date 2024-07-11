<?php
/**
 * Header block template file.
 *
 * @package Creode Blocks
 */

$menus                = wp_get_nav_menus();
$default_menu         = array_shift( $menus );
$inner_block_template = array(
	array(
		'acf/creode-header-logo',
	),
	array(
		'acf/creode-header-menu',
		array(
			'name' => 'acf/creode-header-menu',
			'data' => array(
				'menu_id'  => $default_menu ? $default_menu->term_id : '',
				'_menu_id' => 'field_header_menu',
			),
		),
	),
);
?>

<header class="header__wrapper">
	<div class="header__inner">
		<div class="header__sections">
			<InnerBlocks
				allowedBlocks="<?php echo esc_attr( wp_json_encode( CreodeBlocks\Block::get_child_block_names( 'acf/creode-header' ) ) ); ?>"
				template="<?php echo esc_attr( wp_json_encode( $inner_block_template ) ); ?>"
			/>
		</div>
	</div>
</header>
