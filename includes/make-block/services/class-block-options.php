<?php

namespace Creode_Blocks\Make_Block\Services;

/**
 * Handles the block options.
 */
class Block_Options {
	/**
	 * The no scss flag.
	 *
	 * @var bool
	 */
	protected bool $scss = true;

	/**
	 * Constructor.
	 */
	public function __construct() {}

	/**
	 * Set the scss flag.
	 *
	 * @param boolean $scss The scss flag.
	 *
	 * @return boolean
	 */
	public function get_scss(): bool {
		return $this->scss;
	}

	/**
	 * Set the scss flag.
	 *
	 * @param boolean $scss The scss flag.
	 *
	 * @return static
	 */
	public function set_scss( bool $scss ): static {
		$this->scss = $scss;

		return $this;
	}
}
