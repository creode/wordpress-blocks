/**
 * Admin block class.
 * Extend this class to control a block within the editor.
 *
 * @package Creode Blocks
 */
class AdminBlock {

	/**
	 * The listeners to trigger when changes are detected.
	 * @type {Array<Function>}
	 */
	listeners = [];

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
		this.watchBlock();
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
	 * Watch the block for changes and trigger listeners when changes are detected.
	 *
	 * @returns {void}
	 */
	watchBlock() {
		const clientId = this.blockDiv.data('block');

			wp.data.subscribe(
			() => {
				const updatedBlock = wp.data.select('core/block-editor').getBlock(clientId);

				AdminHelpers.deepCompare(
					this.block,
					updatedBlock,
					(path, originalValue, newValue) => {
						for (const listener of this.listeners) {
							listener(path, originalValue, newValue);
						}
						this.loadBlock();
					}
				);
			}
		);
	}

	/**
	 * Add a listener to the block. The listener will be triggered when changes are detected.
	 *
	 * @param {Function} listener - The listener to add. The listener will be triggered with the following arguments:
	 * - {string} path - The path of the attribute that changed.
	 * - {any} originalValue - The original value of the attribute.
	 * - {any} newValue - The new value of the attribute.
	 * @returns {void}
	 */
	addListener(listener) {
		this.listeners.push(listener);
	}

	/**
	 * Overidable method to perform block specific setup tasks.
	 */
	setup() {}

	/**
	 * Set a block attribute.
	 * Re-render the block.
	 *
	 * @param {string} name - The name of the attribute.
	 * @param {any} value - The value of the attribute.
	 * @returns {void}
	 */
	setAttribute(name, value) {
		let attributes = {
			_forceRender: Date.now()
		};

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