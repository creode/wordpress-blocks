<?php
/**
 * Site header block class.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Site header block class.
 *
 * @wordpress-block-version 1.10.1
 */
class Site_Header_Block extends Block {

	use Trait_Restrict_To_Site_Editor;
	use Trait_Has_Modifier_Classes;

	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/ or an inline SVG.
	 *
	 * @var string
	 */
	protected $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M18.5 10.5H10v8h8a.5.5 0 00.5-.5v-7.5zm-10 0h-3V18a.5.5 0 00.5.5h2.5v-8zM6 4h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z"></path></svg>';

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'site-header';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'Site header';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function child_blocks(): array {
		return array(
			new Child_Block(
				'general',
				'General',
				__DIR__ . '/templates/general.php',
				array(
					array(
						'key'     => 'field_header_block_general_device_visibility',
						'name'    => 'device_visibility',
						'label'   => 'Device Visibility',
						'type'    => 'select',
						'choices' => array(
							'all'     => 'All',
							'mobile'  => 'Mobile Only',
							'desktop' => 'Desktop Only',
						),
					),
				),
				array(),
				'editor-help'
			),
			new Child_Block(
				'logo',
				'Logo',
				__DIR__ . '/templates/logo.php',
				array(
					array(
						'key'     => 'field_header_block_logo_information',
						'name'    => 'information',
						'label'   => 'Information',
						'type'    => 'message',
						'message' => 'This will render the file located at: "/images/logo.svg", relative to the active theme root directory.',
					),
				),
				array(),
				'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M12 3c-5 0-9 4-9 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 1.5c4.1 0 7.5 3.4 7.5 7.5v.1c-1.4-.8-3.3-1.7-3.4-1.8-.2-.1-.5-.1-.8.1l-2.9 2.1L9 11.3c-.2-.1-.4 0-.6.1l-3.7 2.2c-.1-.5-.2-1-.2-1.5 0-4.2 3.4-7.6 7.5-7.6zm0 15c-3.1 0-5.7-1.9-6.9-4.5l3.7-2.2 3.5 1.2c.2.1.5 0 .7-.1l2.9-2.1c.8.4 2.5 1.2 3.5 1.9-.9 3.3-3.9 5.8-7.4 5.8z"></path></svg>',
			),
			new Child_Block(
				'desktop-menu',
				'Desktop Menu',
				__DIR__ . '/templates/desktop-menu.php',
				array(
					array(
						'key'     => 'field_header_block_desktop_menu_information',
						'name'    => 'information',
						'label'   => 'Information',
						'type'    => 'message',
						'message' => 'The "desktop-menu" template part will be rendered here.',
					),
				),
				array(),
				'<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" aria-hidden="true" focusable="false"><path d="M12 4c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 14.5c-3.6 0-6.5-2.9-6.5-6.5S8.4 5.5 12 5.5s6.5 2.9 6.5 6.5-2.9 6.5-6.5 6.5zM9 16l4.5-3L15 8.4l-4.5 3L9 16z"></path></svg>'
			),
			new Child_Block(
				'mobile-menu-toggle',
				'Mobile Menu Toggle',
				__DIR__ . '/templates/mobile-menu-toggle.php',
				array(
					array(
						'key'     => 'field_header_block_mobile_menu_toggle_information',
						'name'    => 'information',
						'label'   => 'Information',
						'type'    => 'message',
						'message' => 'This button will toggle the display of the "mobile-menu" template part.',
					),
				),
				array(),
				'menu'
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function template(): string {
		return __DIR__ . '/templates/block.php';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function modifier_classes(): array {
		$classes = array();

		if ( is_admin() ) {
			array_push( $classes, 'active' );
		}

		return $classes;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function setup(): bool {
		$this->register_script();
		return parent::setup();
	}

	/**
	 * Registers the header JavaScript file.
	 */
	protected function register_script() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_register_script(
					'site_header',
					plugin_dir_url( __FILE__ ) . 'assets/site-header.js',
					array(
						'jquery',
					),
					1,
					true
				);
			}
		);
	}
}
