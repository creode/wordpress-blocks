/**
 * @class Mobile_Menu
 * @classdesc
 *   Manages the behavior of a mobile menu component.
 *   Provides the ability to close the menu via the internal toggle element.
 *   Triggers a 'mobile_menu_toggle' event, which can be handled externally to show or hide the menu.
 */
class Mobile_Menu {

	/**
	 * Stores references to relevant DOM elements for the mobile menu.
	 * @type {Object}
	 * @property {jQuery} wrapper - The top-level menu wrapper element.
	 * @property {jQuery} toggle  - The toggle element used to trigger menu open/close.
	 */
	elements = {};

	/**
	 * Creates an instance of Mobile_Menu.
	 * @param {jQuery} wrapper - The jQuery object representing the menu's wrapper element.
	 */
	constructor(wrapper) {
		this.loadElements(wrapper);   // Cache relevant DOM elements.
		this.initializeToggle();      // Attach event listeners to the toggle.
	}

	/**
	 * Caches references to important DOM elements within the menu wrapper.
	 *
	 * @param {jQuery} wrapper - The menu's outer wrapper element.
	 */
	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.toggle = wrapper.find('.mobile-menu__toggle');
	}

	/**
	 * Sets up the event listener for the toggle element.
	 * When clicked, it calls the toggle() method to trigger the menu event.
	 */
	initializeToggle() {
		this.elements.toggle.on(
			'click',
			() => {
				this.toggle();
			}
		);
	}

	/**
	 * Triggers a global event to toggle the mobile menu's state.
	 * Separate scripts should listen for the 'mobile_menu_toggle' event and handle show/hide logic.
	 */
	toggle() {
		jQuery(window).trigger('mobile_menu_toggle');
	}
}

jQuery(document).ready(
	() => {
		// Store all Mobile_Menu instances globally for potential later access.
		window.mobileMenu = [];

		// Find all menu wrappers on the page.
		let wrappers = jQuery('.mobile-menu__wrapper');

		// Instantiate a Mobile_Menu controller for each wrapper found.
		wrappers.each(
			(index) => {
				window.mobileMenu.push(new Mobile_Menu(wrappers.eq(index)));
			}
		);
	}
);
