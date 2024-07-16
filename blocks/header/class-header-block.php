<?php
/**
 * Header block definition.
 *
 * @package Creode Blocks
 */

namespace CreodeBlocks;

/**
 * Header block definition.
 */
class HeaderBlock extends Block {

	/**
	 * {@inheritDoc}
	 */
	protected function name() {
		return 'creode-header';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function label() {
		return 'Creode Header';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function fields() {
		return array();
	}

	/**
	 * {@inheritDoc}
	 */
	protected function template() {
		return plugin_dir_path( __FILE__ ) . 'templates/header.php';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function child_blocks() {
		$menus_choices = array(
			'' => 'None',
		);
		foreach ( wp_get_nav_menus() as $menu_term ) {
			$menus_choices[ $menu_term->term_id ] = $menu_term->name;
		}

		return array(
			new ChildBlock(
				'logo',
				'Logo',
				array(),
				plugin_dir_path( __FILE__ ) . 'templates/logo.php'
			),
			new ChildBlock(
				'general',
				'General',
				array(),
				plugin_dir_path( __FILE__ ) . 'templates/general.php'
			),
			new ChildBlock(
				'menu',
				'Menu',
				array(
					array(
						'key'     => 'field_header_menu',
						'label'   => 'Menu',
						'name'    => 'menu_id',
						'type'    => 'select',
						'choices' => $menus_choices,
					),
				),
				plugin_dir_path( __FILE__ ) . 'templates/menu.php'
			),
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function __construct() {
		parent::__construct();
		$this->register_script();
	}

	/**
	 * Registers nessisary javascript.
	 */
	protected function register_script() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_register_script(
					'header',
					plugin_dir_url( __FILE__ ) . 'js/header.js',
					array(
						'jquery',
					),
					'1.0.0',
					array(
						'in_footer' => true,
					)
				);
			}
		);
	}
}
