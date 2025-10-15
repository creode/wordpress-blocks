<?php
/**
 * Abstract class to extend for each block.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Class used to enqueue a block specific script.
 */
class Script {

	/**
	 * Script handle.
	 *
	 * @var string
	 */
	private string $handle;

	/**
	 * Script source URL.
	 *
	 * @var string
	 */
	private string $src;

	/**
	 * Script dependencies.
	 *
	 * @var array
	 */
	private array $deps;

	/**
	 * Script version.
	 *
	 * @var string
	 */
	private string $ver;

	/**
	 * Script arguments.
	 *
	 * @var array
	 */
	private array $args;

	/**
	 * Constructor.
	 *
	 * @param string $handle Script handle.
	 * @param string $src Script source URL.
	 * @param array  $deps Script dependencies.
	 * @param string $ver Script version.
	 */
	public function __construct( string $handle, string $src, array $deps = array(), string $ver = '1' ) {
		$this->handle = $handle;
		$this->src    = $src;
		$this->deps   = $deps;
		$this->ver    = $ver;
	}

	/**
	 * Getter for the script properties.
	 *
	 * @param string $name Property name.
	 * @return mixed
	 */
	public function __get( string $name ) {
		return $this->$name;
	}
}
