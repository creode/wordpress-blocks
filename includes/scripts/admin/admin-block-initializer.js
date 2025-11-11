/**
 * Admin script initialization handler.
 * This will handle the initialisation of block javascript in the admin area.
 * Instantiate this class with a CSS selector for the block's outermost div and a method to initialize it's admin javascript.
 * The initialization method will run when the editor is loaded and when any new instance of the block is added to the editor.
 * The initialization method will be provided with a jQuery object representing the block's outermost div.
 * This functionality will not initialize the same block instance multiple times.
 *
 * @package Creode Blocks
 */

class AdminBlockInitializer {

	/**
	 * Constructor.
	 *
	 * @param {string} selector - The CSS selector for the block's outermost div.
	 * @param {function} initializationMethod - The method to initialise the block's admin javascript.
	 */
	constructor(selector, initializationMethod) {
		this.selector = selector;
		this.initializationMethod = initializationMethod;
		this.initializeOnDomReady();
		this.initializeOnBlockAdded();
	}

	initializeOnDomReady() {
		jQuery(document).ready(
			() => {
				this.initialize();
			}
		);
	}

	initializeOnBlockAdded() {
		const observer = new MutationObserver(
			(mutations) => {
				mutations.forEach(
					(mutation) => {
						mutation.addedNodes.forEach(
							(node) => {
								if (node.nodeType !== 1) {
									return;
								}

								// Check if the added node itself matches the selector.
								if (node.matches(this.selector)) {
									this.initialize();
								}
								// Also check if any descendant matches the selector.
								node.querySelectorAll(this.selector).forEach(
									() => {
										this.initialize();
									}
								);
							}
						);
					}
				);
			}
		);

		// Start observing the document body for changes
		observer.observe(
			document.body,
			{
				childList: true,
				subtree: true,
			}
		);
	}

	initialize() {
		const blockDivs = jQuery(this.selector);

		blockDivs.each(
			(index) => {
				if (blockDivs.eq(index).data('initialized')) {
					return;
				}
				blockDivs.eq(index).data('initialized', true);
				this.initializationMethod(blockDivs.eq(index));
			}
		);
	}
}
