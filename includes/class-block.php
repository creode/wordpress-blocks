<?php
/**
 * Abstract class to extend for each block.
 *
 * @package Creode Blocks
 */

namespace CreodeBlocks;

/**
 * Abstract class to extend for each block.
 */
abstract class Block {

	/**
	 * Function for providing the block's name.
	 *
	 * @return string The block's name (must be hyphen separated).
	 */
	abstract protected function name();

	/**
	 * Function for providing the block's label to be used within the WordPress UI.
	 *
	 * @return string The block's label.
	 */
	abstract protected function label();

	/**
	 * Function for providing fields array.
	 *
	 * @return array An array of field definitions in ACF format. Please see: https://www.advancedcustomfields.com/resources/register-fields-via-php/.
	 */
	abstract protected function fields();

	/**
	 * Function for providing a path to the render template.
	 *
	 * @return string The path to the render template.
	 */
	abstract protected function template();

	/**
	 * Function for providing the block's category.
	 *
	 * @return string The block's category.
	 */
	protected function category() {
		return 'common';
	}

	/**
	 * Function for providing the child blocks
	 *
	 * @return ChildBlock[] Array of child blocks.
	 */
	protected function child_blocks() {
		return array();
	}

	/**
	 * Function for fully registering the block and all associated functionality.
	 */
	public function __construct() {
		$this->register_acf_block();
		$this->register_acf_fields();

		foreach ( $this->child_blocks() as $child_block ) {
			$this->register_child_block( $this->name(), $child_block, $this->name() );
		}
	}

	/**
	 * Function to register the block with ACF.
	 */
	protected function register_acf_block() {
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			return;
		}

		acf_register_block_type(
			array(
				'name'            => $this->name(),
				'title'           => $this->label(),
				'category'        => $this->category(),
				'render_template' => $this->template(),
				'supports'        => array(
					'jsx' => true,
				),
			)
		);
	}

	/**
	 * Function to register the block's fields with ACF.
	 */
	protected function register_acf_fields() {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'      => 'group_' . $this->name() . '_block',
				'title'    => $this->label(),
				'fields'   => $this->fields(),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/' . $this->name(),
						),
					),
				),
			)
		);
	}

	/**
	 * Function for fully registering child blocks.
	 *
	 * @param string     $parent_block The parent block name.
	 * @param ChildBlock $child_block The child block to register.
	 */
	protected function register_child_block( string $parent_block, ChildBlock $child_block ) {
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			return;
		}

		// Register ACF block.
		acf_register_block_type(
			array(
				'name'            => $parent_block . '-' . $child_block->name,
				'title'           => $child_block->label,
				'render_template' => $child_block->template,
				'parent'          => array(
					'acf/' . $parent_block,
				),
				'supports'        => array(
					'jsx' => true,
				),
			)
		);

		// Register relationship so that it can be referenced in other functions.
		add_filter(
			'creode_blocks_parent_child_relationship',
			function ( array $blocks ) use ( $parent_block, $child_block ) {
				if ( empty( $blocks[ 'acf/' . $parent_block ] ) ) {
					$blocks[ 'acf/' . $parent_block ] = array();
				}
				array_push( $blocks[ 'acf/' . $parent_block ], 'acf/' . $parent_block . '-' . $child_block->name );

				return $blocks;
			}
		);

		// Register block fields.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $parent_block . '-' . $child_block->name . '_block',
					'title'    => $child_block->label,
					'fields'   => $child_block->fields,
					'location' => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/' . $parent_block . '-' . $child_block->name,
							),
						),
					),
				)
			);
		}

		// Register grandchild blocks.
		foreach ( $child_block->child_blocks as $grand_child_block ) {
			$this->register_child_block(
				$parent_block . '-' . $child_block->name,
				$grand_child_block
			);
		}
	}

	public static function get_child_block_names( $parent_block_name ) {
		$parent_child_relationship = apply_filters( 'creode_blocks_parent_child_relationship', array() );

		if ( empty( $parent_child_relationship[ $parent_block_name ] ) ) {
			return null;
		}

		return $parent_child_relationship[ $parent_block_name ];
	}
}
