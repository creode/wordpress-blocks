<?php
/**
 * File to load all blocks.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

// Load utility blocks.
require_once plugin_dir_path( __FILE__ ) . 'integrated-pattern/class-integrated-pattern-block.php';
require_once plugin_dir_path( __FILE__ ) . 'integrated-menu/class-integrated-menu-block.php';

// Initialise utility blocks.
add_action(
	'init',
	function () {
		if ( ! apply_filters( 'creode_blocks_include_utilities', true ) ) {
			return;
		}

		// Add Creode Utilities category.
		add_filter(
			'block_categories_all',
			function ( array $categories ) {
				array_push(
					$categories,
					array(
						'slug'  => 'creode-utilities',
						'title' => 'Creode Utilities',
					)
				);

				return $categories;
			}
		);

		Integrated_Pattern_Block::init();
		Integrated_Menu_Block::init();
	},
	5
);

// Load optional blocks.
require_once plugin_dir_path( __FILE__ ) . 'header/class-header-block.php';
require_once plugin_dir_path( __FILE__ ) . 'search-and-filter/class-search-and-filter-block.php';
