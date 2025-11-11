---
title: get_child_block_by_path
editLink: false
---

# get_child_block_by_path

## Description

The `get_child_block_by_path()` method finds a child block from an array of existing child blocks based on its path. This method is particularly useful when you need to access and modify a specific child block within a nested child block structure.

### Responsibility

This method recursively searches through an array of child blocks using a path-based approach (e.g., "table/row/cell") to locate a specific child block. It validates the path and throws an exception if the block cannot be found, ensuring type safety and preventing silent failures.

### Arguments

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$existing_child_blocks` | `Child_Block[]` | Yes | An array of existing child blocks to search in |
| `$path` | `string` | Yes | A "/" separated path to block (e.g., "table/row/cell" or "table/row/cell/cell-content") |

### Return Value

- **Type**: `Child_Block`
- **Description**: Returns the matching Child_Block instance if found
- **Throws**: `\InvalidArgumentException` if the path is invalid or the block cannot be found

## Path Format

The path parameter uses a forward-slash (`/`) separated format to navigate through nested child blocks:

- Each segment represents a child block name
- The path is traversed from top to bottom
- Example: `"table/row/cell"` means:
  - Find a child block named "table"
  - Within that, find a child block named "row"
  - Within that, find a child block named "cell"
  - Return that "cell" block

## Pairing with replace_child_block_by_path

This function pairs exceptionally well with `replace_child_block_by_path()`. The typical workflow is:

1. Use `get_child_block_by_path()` to retrieve the existing child block you want to modify
2. Make your modifications to the retrieved block (e.g., add fields, change configuration)
3. Use `replace_child_block_by_path()` to replace the original block with your modified version

This pattern allows you to extend child blocks defined in parent classes without having to completely recreate the entire child block hierarchy.

## Examples

### Basic Usage - Retrieving a Child Block

This example shows how to retrieve a child block from a nested structure:

```php
use Creode_Blocks\Helpers;

protected function child_blocks(): array {
	$existing_child_blocks = parent::child_blocks();

	// Get a specific child block by path
	$cell_block = Helpers::get_child_block_by_path(
		$existing_child_blocks,
		'table/row/cell'
	);

	// Now you can access the block's properties
	$fields = $cell_block->fields;
	$template = $cell_block->template;
}
```

### Extending a Child Block with Additional Fields

This is the most common use case - extending a child block defined in a parent class by adding new fields:

```php
use Creode_Blocks\Table_Block as Base_Table_Block;
use Creode_Blocks\Helpers;

class Table extends Base_Table_Block {

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
		return 'Comparison Table';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function child_blocks(): array {
		$existing_child_blocks = parent::child_blocks();

		// Get the existing cell-content child block
		$cell_content_child_block = Helpers::get_child_block_by_path(
			$existing_child_blocks,
			'table/row/cell/cell-content'
		);

		// Get the existing fields array and add the new field to it
		$fields = $cell_content_child_block->fields;
		$fields[] = array(
			'key'     => 'creode_field',
			'label'   => 'Creode Field',
			'name'    => 'creode_field',
			'type'    => 'select',
			'choices' => array(
				''  => 'hooray',
				'1' => 'woohoo',
				'2' => 'I did it',
			),
		);
		$cell_content_child_block->fields = $fields;

		// Replace the original block with the modified version
		$replaced_child_blocks = Helpers::replace_child_block_by_path(
			$existing_child_blocks,
			'table/row/cell/cell-content',
			$cell_content_child_block
		);

		return $replaced_child_blocks;
	}
}
```

### Modifying Multiple Properties

You can modify multiple properties of the retrieved child block:

```php
use Creode_Blocks\Helpers;

protected function child_blocks(): array {
	$existing_child_blocks = parent::child_blocks();

	$target_block = Helpers::get_child_block_by_path(
		$existing_child_blocks,
		'section/header'
	);

	// Modify multiple properties
	// Get the existing fields array, modify it, then reassign it
	$fields = $target_block->fields;
	$fields[] = array(
		'key'   => 'new_field',
		'label' => 'New Field',
		'name'  => 'new_field',
		'type'  => 'text',
	);
	$target_block->fields = $fields;

	$target_block->template = __DIR__ . '/templates/custom-header.php';

	// Replace with modified version
	return Helpers::replace_child_block_by_path(
		$existing_child_blocks,
		'section/header',
		$target_block
	);
}
```

## Error Handling

The method throws `\InvalidArgumentException` in two scenarios:

1. **Invalid path**: If the path is empty or contains no valid segments
2. **Block not found**: If any segment in the path cannot be matched to an existing child block

```php
use Creode_Blocks\Helpers;

try {
	$block = Helpers::get_child_block_by_path(
		$existing_child_blocks,
		'invalid/path/to/block'
	);
} catch ( \InvalidArgumentException $e ) {
	// Handle the error - block not found at specified path
	error_log( $e->getMessage() );
}
```

## Use Cases

This helper is particularly useful when:

- **Extending parent block classes**: You want to add fields or modify properties of a child block defined in a parent class
- **Selective modifications**: You only need to modify specific child blocks in a complex hierarchy
- **Dynamic child block manipulation**: You need to programmatically access and modify nested child blocks
- **Pairing with replace_child_block_by_path**: You want to retrieve, modify, and replace a child block in one workflow

## Notes

- The path matching is case-sensitive and must exactly match the child block names
- Only the first matching child block at each level is returned (if multiple child blocks share the same name, only the first one is found)
- The method validates the entire path before returning, ensuring the block exists at the specified location
- Always use this method in conjunction with `replace_child_block_by_path()` when you need to persist your modifications

