<?php
/**
 * Table block class.
 *
 * @package Sovereign Health Care
 */

namespace Creode_Blocks;

/**
 * Table block class.
 *
 * @wordpress-block-version 2.3.0
 */
class Table_Block extends Block {

	use Trait_Has_Modifier_Classes;
	use Trait_Has_Reduce_Bottom_Space_Option;
	use Trait_Has_Icons;
	use Trait_Has_Color_Choices;

	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/ or an inline SVG.
	 *
	 * @var string
	 */
	protected $icon = 'editor-table';

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'table';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'Table';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function fields(): array {
		return array(
			array(
				'key'   => 'field_table_id',
				'label' => 'ID',
				'name'  => 'id',
				'type'  => 'text',
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function child_blocks(): array {
		return array(
			new Child_Block(
				'additional-content',
				'Additional Content',
				array(),
				__DIR__ . '/templates/additional-content.php',
				array(),
				'text'
			),
			new Child_Block(
				'table',
				'Table',
				array(
					array(
						'key'          => 'field_table_device_visibility',
						'label'        => 'Device Visibility',
						'name'         => 'device_visibility',
						'type'         => 'select',
						'instructions' => 'Please choose which devices the table should be visible on.',
						'choices'      => array(
							'all'          => 'All',
							'desktop-only' => 'Desktop Only',
							'mobile-only'  => 'Mobile Only',
						),
					),
				),
				__DIR__ . '/templates/table.php',
				array(
					new Child_Block(
						'row',
						'Table Row',
						array(
							array(
								'key'           => 'field_table_row_has_bottom_space',
								'label'         => 'Bottom Space',
								'name'          => 'has_bottom_space',
								'type'          => 'true_false',
								'message'       => 'Has bottom space?',
								'default_value' => true,
							),
						),
						__DIR__ . '/templates/row.php',
						array(
							new Child_Block(
								'cell',
								'Table Cell',
								array(
									array(
										'key'           => 'field_table_cell_colspan',
										'label'         => 'Colspan',
										'name'          => 'colspan',
										'type'          => 'number',
										'instructions'  => 'The number of columns the cell should span. This will not be reflected in the editor.',
										'default_value' => 1,
									),
								),
								__DIR__ . '/templates/cell.php',
								array(
									new Child_Block(
										'cell-content',
										'Table Cell Content',
										array(),
										__DIR__ . '/templates/cell-content.php',
										array(),
										'text',
										array(
											'mode'  => false,
											'color' => array(
												'text' => true,
												'background' => true,
											),
										),
									),
								),
								'table-col-after'
							),
						),
						'table-row-after'
					),
				),
				'editor-table'
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
	protected function supports(): array {
		return array(
			'mode'  => false,
			'color' => array(
				'text'       => true,
				'background' => true,
			),
		);
	}
}
