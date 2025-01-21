<?php
/**
 * Trait for adding a "Reduce Bottom Space" setting.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

use Exception;

/**
 * Trait for adding a "Reduce Bottom Space" setting.
 */
trait Trait_Has_Reduce_Bottom_Space_Option {

	/**
	 * Trait initialization function.
	 */
	protected function init_trait_has_reduce_bottom_space_option() {
		$this->trait_has_reduce_bottom_space_option_dependency_check();
		$this->add_reduce_bottom_space_field();
		$this->add_reduce_bottom_space_modifier_class();
	}

	/**
	 * Check to ensure trait is used alongside Creode_Blocks\Trait_Has_Modifier_Classes.
	 *
	 * @throws Exception Describes trait requirements and how to resolve the issue.
	 */
	private function trait_has_reduce_bottom_space_option_dependency_check() {
		if ( ! in_array( 'Creode_Blocks\Trait_Has_Modifier_Classes', class_uses( $this::class ), true ) ) {
			throw new Exception( 'Creode_Blocks\Trait_Has_Reduce_Bottom_Space_Option should only ever be used alongside Creode_Blocks\Trait_Has_Modifier_Classes. Please add this trait to ' . $this::class . ' and conform to its requirements.' );
		}
	}

	/**
	 * Adds a "Reduce Bottom Space" field to the current block field group.
	 */
	private function add_reduce_bottom_space_field() {
		$block_name = $this->name();

		add_filter(
			'block-' . $block_name . '-fields',
			function ( array $fields ) use ( $block_name ) {
				array_push(
					$fields,
					array(
						'key'          => 'field_' . str_replace( '-', '_', $block_name ) . '_reduce_bottom_space',
						'name'         => 'reduce_bottom_space',
						'label'        => 'Bottom Space',
						'message'      => 'Reduce Bottom Space',
						'instructions' => 'Useful when there is no clear boundary between an adjacent block.',
						'type'         => 'true_false',
					)
				);

				return $fields;
			},
			20
		);
	}

	/**
	 * Adds a modifier class to the output of the get_modifier_class_string function provided by the Trait_Has_Modifier_Classes trait.
	 */
	private function add_reduce_bottom_space_modifier_class() {
		add_filter(
			'block-' . $this->name() . '-modifier-classes',
			function ( array $classes ) {
				if ( ! empty( get_field( 'reduce_bottom_space' ) ) ) {
					array_push( $classes, 'reduce-bottom-space' );
				}

				return $classes;
			}
		);
	}
}
