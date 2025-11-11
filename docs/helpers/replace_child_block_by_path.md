---
title: replace_child_block_by_path
editLink: false
---

# replace_child_block_by_path

## Description

The `replace_child_block_by_path()` method targets a child block by its path within a nested child block structure and replaces it with a new child block definition. This is particularly useful when you need to override or extend child blocks that are defined in a parent block class.

### Responsibility

This method recursively searches through an array of child blocks using a path-based approach (e.g., "table/row/cell") to locate a specific child block, then replaces it with a new `Child_Block` instance. This allows you to modify child blocks that are defined in parent classes without having to completely redefine the entire child block hierarchy.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$existing_child_blocks` | `Child_Block[]` | Yes | An array of existing child blocks to search in |
| `$path` | `string` | Yes | A "/" separated path to the target block (e.g., "table/row/cell" or "table/row/cell/cell-content") |
| `$new_child_block` | `Child_Block` | Yes | The new child block instance to replace the existing one |

### Return Value

- **Type**: `Child_Block[]`
- **Description**: Returns the array of child blocks with the specified block replaced

## Path Format

The path parameter uses a forward-slash (`/`) separated format to navigate through nested child blocks:

- Each segment represents a child block name
- The path is traversed from top to bottom
- Example: `"table/row/cell"` means:
  - Find a child block named "table"
  - Within that, find a child block named "row"
  - Within that, find a child block named "cell"
  - Replace that "cell" block with the new one

## Examples

### Basic Usage - Overriding a Child Block

This example shows how to override a child block defined in a parent class by replacing it with a new version that includes additional fields:

```php
use Creode_Blocks\Helpers;
use Creode_Blocks\Child_Block;

/**
 * {@inheritdoc}
 */
protected function child_blocks(): array {
	$existing_child_blocks = parent::child_blocks();

	// Replace the cell-content child block with an enhanced version
	$replaced_child_blocks = Helpers::replace_child_block_by_path(
		$existing_child_blocks,
		'table/row/cell/cell-content',
		new Child_Block(
			'cell-content',
			'Table Cell Content',
			array(
				array(
					'key'     => 'field_table_cell_style',
					'label'   => 'Style',
					'name'    => 'style',
					'type'    => 'select',
					'choices' => array(
						''  => 'None',
						'1' => 'No Padding',
					),
				),
				array(
					'key'     => 'field_table_cell_curved_corners',
					'label'   => 'Curved corners',
					'name'    => 'curved_corners',
					'type'    => 'checkbox',
					'choices' => array(
						'top-left'     => 'Top Left',
						'top-right'    => 'Top Right',
						'bottom-right' => 'Bottom Right',
						'bottom-left'  => 'Bottom Left',
					),
				),
				$this->get_icon_field_schema( 'field_table_cell_icon', true ),
				array(
					'key'     => 'field_table_cell_icon_color',
					'label'   => 'Icon Color',
					'name'    => 'icon_color',
					'type'    => 'radio',
					'choices' => $this->get_color_choices(),
					'conditional_logic' => array(
						array(
							array(
								'field'    => 'field_table_cell_icon',
								'operator' => '!=',
								'value'    => '',
							),
						),
					),
				),
			),
			CREODE_BLOCKS_PLUGIN_FOLDER . '/blocks/table/templates/cell-content.php',
			array(),
			'text',
			array(
				'mode'  => false,
				'color' => array(
					'text'       => true,
					'background' => true,
				),
			),
		),
	);

	return $replaced_child_blocks;
}
```

### Shallow Path Replacement

You can also replace child blocks at the top level of the hierarchy:

```php
use Creode_Blocks\Helpers;
use Creode_Blocks\Child_Block;

protected function child_blocks(): array {
	$existing_child_blocks = parent::child_blocks();

	// Replace a top-level child block
	$replaced_child_blocks = Helpers::replace_child_block_by_path(
		$existing_child_blocks,
		'section',
		new Child_Block(
			'section',
			'Enhanced Section',
			array(
				// Additional fields here
			),
			__DIR__ . '/templates/enhanced-section.php'
		),
	);

	return $replaced_child_blocks;
}
```

## Use Cases

This helper is particularly useful when:

- **Extending parent block classes**: You want to add fields to a child block defined in a parent class without modifying the parent
- **Customizing child blocks**: You need to modify the template, fields, or configuration of a nested child block
- **Selective overrides**: You only want to change specific child blocks in a complex hierarchy rather than redefining everything

## Notes

- If the path doesn't match any existing child blocks, the original array is returned unchanged
- The path matching is case-sensitive and must exactly match the child block names
- Only the first matching child block at each level is replaced (if multiple child blocks share the same name, only the first one is affected)
- The replacement maintains the position of the original child block in the array

