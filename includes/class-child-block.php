<?php
/**
 * Class to store child block definition.
 *
 * @package Creode Blocks
 */

namespace CreodeBlocks;

/**
 * Class to store child block definition.
 */
class ChildBlock {

	/**
	 * The child block's name.
	 *
	 * @var string The child block's name (must be hyphen separated).
	 */
	protected $name = '';

	/**
	 * The child block's label to be used within the WordPress UI.
	 *
	 * @var string The child block's label.
	 */
	protected $label = '';

	/**
	 * The child block's fields.
	 *
	 * @var array An array of field definitions in ACF format. Please see: https://www.advancedcustomfields.com/resources/register-fields-via-php/.
	 */
	protected $fields = array();

	/**
	 * A path to the render template.
	 *
	 * @var string A path to the render template.
	 */
	protected $template = '';

	/**
	 * The child block's child blocks.
	 *
	 * @var ChildBlock[] Array of child blocks.
	 */
	protected $child_blocks = array();

	/**
	 * Data input function.
	 *
	 * @param string       $name The child block's name (must be hyphen separated).
	 * @param string       $label The child block's label.
	 * @param array        $fields An array of field definitions in ACF format. Please see: https://www.advancedcustomfields.com/resources/register-fields-via-php/.
	 * @param string       $template A path to the render template.
	 * @param ChildBlock[] $child_blocks (Optional) Array of child blocks.
	 */
	public function __construct(
		string $name,
		string $label,
		array $fields = array(),
		string $template = '',
		array $child_blocks = array()
	) {
		$this->name         = $name;
		$this->label        = $label;
		$this->fields       = $fields;
		$this->template     = $template;
		$this->child_blocks = $child_blocks;
	}

	/**
	 * Function for retrieving read-only properties.
	 *
	 * @param string $property The property to retrieve.
	 */
	public function __get( string $property ) {
		return $this->$property;
	}
}
