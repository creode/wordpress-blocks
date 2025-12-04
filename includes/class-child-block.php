<?php
/**
 * Class to store child block definition.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Class to store child block definition.
 */
class Child_Block {

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
	 * @var array An array of field definitions in ACF format.
	 *
	 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/ ACF Field documentation.
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
	 * @var Child_Block[] Array of child blocks.
	 */
	protected $child_blocks = array();

	/**
	 * Icon for Child block.
	 *
	 * @var string|null
	 */
	protected $icon = null;

	/**
	 * Allows configuration to supports section of block configuration.
	 *
	 * @var array
	 */
	protected $supports = array();

	/**
	 * Data input function.
	 *
	 * @param string        $name The child block's name (must be hyphen separated).
	 * @param string        $label The child block's label.
	 * @param string        $template A path to the render template.
	 * @param array         $fields (Optional) An array of field definitions in ACF format.
	 * @param Child_Block[] $child_blocks (Optional) Array of child blocks.
	 * @param string|null   $icon (Optional) Icon for Child block. If not provided, icon will be inherited from the parent block.
	 * @param bool          $background_color_configurable (Optional) Whether the background color is configurable.
	 * @param bool          $text_color_configurable (Optional) Whether the text color is configurable.
	 */
	public function __construct(
		string $name,
		string $label,
		string $template,
		array $fields = array(),
		array $child_blocks = array(),
		?string $icon = null,
		bool $background_color_configurable = false,
		bool $text_color_configurable = false,
	) {
		$this->name         = $name;
		$this->label        = $label;
		$this->template     = $template;
		$this->fields       = $fields;
		$this->child_blocks = $child_blocks;
		$this->icon         = $icon;

		// Generate supports array.
		$this->supports = array(
			'mode'  => false,
			'color' => array(
				'background' => $background_color_configurable,
				'text'       => $text_color_configurable,
			),
		);
	}

	/**
	 * Function for retrieving read-only properties.
	 *
	 * @param string $property The property to retrieve.
	 */
	public function __get( string $property ) {
		return $this->$property;
	}

	/**
	 * Function to run when setting any properties.
	 *
	 * @param string $name Name of property to set.
	 * @param mixed  $value Value of the property.
	 *
	 * @throws \InvalidArgumentException Thrown if you are trying to set an invalid property.
	 *
	 * @return void
	 */
	public function __set( string $name, mixed $value ): void {
		// Check the property is actually present on the class.
		if ( ! property_exists( $this, $name ) ) {
			throw new \InvalidArgumentException( sprintf( 'The property "%s" does not exist on the %s class.', esc_html( $name ), esc_html( __CLASS__ ) ) );
		}

		// We shouldn't allow name to be changed as it can have a number of negative side effects.
		if ( 'name' === $name ) {
			throw new \InvalidArgumentException( 'The "name" property is read-only and cannot be modified.' );
		}

		$this->{$name} = $value;
	}

	/**
	 * Function to update the supports configuration.
	 *
	 * @param callable $updater The updater function. This will be passed the current supports array and should return the new supports array.
	 *
	 * @return void
	 */
	public function update_supports( callable $updater ): void {
		$this->supports = $updater( $this->supports );
	}
}
