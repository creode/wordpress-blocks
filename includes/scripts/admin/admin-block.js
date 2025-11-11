/**
 * Admin block class.
 * Extend this class to control a block within the editor.
 *
 * @package Creode Blocks
 */
class AdminBlock {

	/**
	 * Constructor.
	 *
	 * @param {jQuery} blockDiv - The block's outermost div.
	 */
	constructor(blockDiv) {
		this.initialize(blockDiv);
	}

	/**
	 * Initialize the block.
	 * Performs general setup tasks.
	 *
	 * @param {jQuery} blockDiv - The block's outermost div.
	 */
	async initialize(blockDiv) {
		await this.awaitDependancies();

		this.blockDiv = blockDiv;
		this.loadBlock();
		this.setup();
	}

	/**
	 * Asynchronously wait for the generic dependancies to be loaded.
	 * 
	 * @returns {Promise} - A promise that resolves when the dependancies are loaded.
	 */
	async awaitDependancies() {
		return new Promise(
			(resolve) => {
				const interval = setInterval(
					() => {
						if (typeof wp === 'undefined') {
							return;
						}

						clearInterval(interval);
						resolve();
					},
					100
				);
			}
		);
	}

	/**
	 * Load the WordPress block object from the block editor data store.
	 *
	 * @returns {void}
	 */
	loadBlock() {
		const clientId = this.blockDiv.data('block');
		this.block = wp.data.select('core/block-editor').getBlock(clientId);
	}

	/**
	 * Overidable method to perform block specific setup tasks.
	 */
	setup() {}

	/**
	 * Set a block attribute.
	 *
	 * @param {string} name - The name of the attribute.
	 * @param {any} value - The value of the attribute.
	 * @returns {void}
	 */
	setAttribute(name, value) {
		let attributes = {};

		attributes[name] = value;

		wp.data.dispatch('core/block-editor').updateBlockAttributes(
			this.block.clientId,
			attributes
		);

		if ( this.getAttribute(name) !== value ) {
			console.error(`Failed to set attribute ${name} to ${value}`);
		}
	}

	/**
	 * Get a block attribute by name.
	 *
	 * @param {string} name - The name of the attribute.
	 * @returns {any} - The value of the attribute.
	 */
	getAttribute(name) {
		this.loadBlock();
		return this.block.attributes[name];
	}
}