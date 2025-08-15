/**
 * @class Mobile_Menu
 * @classdesc
 *   Manages the behavior of a mobile menu component.
 *   Provides the ability to close the menu via the internal toggle element.
 *   Triggers a 'mobile_menu_toggle' event, which can be handled externally to show or hide the menu.
 *   Handles accessible toggling of sub-menus via .submenu-toggle buttons.
 */
class Mobile_Menu {

	/**
	 * Stores references to relevant DOM elements for the mobile menu.
	 * @type {Object}
	 * @property {jQuery} wrapper - The top-level menu wrapper element.
	 * @property {jQuery} toggle  - The toggle element used to trigger menu open/close.
	 * @property {jQuery} menuWrapper - The element containing the actual menu(s).
	 */
	elements = {};

	/**
	 * Creates an instance of Mobile_Menu.
	 * @param {jQuery} wrapper - The jQuery object representing the menu's wrapper element.
	 */
	constructor(wrapper) {
		this.loadElements(wrapper);         // Cache relevant DOM elements.
		this.initializeToggle();            // Attach event listeners to the main menu toggle.
		this.initializeSubmenuToggles();    // Attach event listeners for sub-menu toggles.
	}

	/**
	 * Caches references to important DOM elements within the menu wrapper.
	 *
	 * @param {jQuery} wrapper - The menu's outer wrapper element.
	 */
	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.toggle = wrapper.find('.mobile-menu__toggle');
		this.elements.menuWrapper = wrapper.find('.mobile-menu__menu-wrapper');
	}

	/**
	 * Sets up the event listener for the main menu toggle element.
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
	 * Sets up event delegation for all sub-menu toggle buttons within the menu wrapper.
	 * This ensures that any .submenu-toggle button, regardless of its location or when it is added,
	 * will have the correct toggle behavior.
	 *
	 * Handles clicking on a .submenu-toggle, prevents default behavior, and toggles
	 * the corresponding sub-menu's visibility and accessibility attributes.
	 */
	initializeSubmenuToggles() {
		this.elements.menuWrapper.on(
			'click',
			'.submenu-toggle',
			(event) => {
				event.preventDefault();

				const button = jQuery(event.currentTarget);
				const submenuId = button.attr('aria-controls');
				this.closeAllSubmenus(submenuId); // Close all except the one being toggled
				this.toggleSubmenu(submenuId);
			}
		);
	}

	/**
	 * Closes all sub-menus except for the one with the given ID.
	 * If exceptionSubmenuId is not provided, all sub-menus will be closed.
	 * Sets their hidden and aria-hidden attributes, and updates their toggle buttons' ARIA states.
	 *
	 * @param {string} [exceptionSubmenuId] - (Optional) The ID of the sub-menu that should NOT be closed.
	 */
	closeAllSubmenus(exceptionSubmenuId) {
		const submenus = this.elements.menuWrapper.find('ul[id^="sub-menu-"]');

		submenus.each(
			(index) => {
				const submenu = submenus.eq(index);
				const submenuId = submenu.attr('id');

				if (typeof exceptionSubmenuId !== 'undefined' && submenuId === exceptionSubmenuId) {
					return;
				}

				// Hide submenu
				submenu.attr('hidden', 'hidden');
				submenu.attr('aria-hidden', 'true');

				// Update corresponding toggle button
				const button = this.elements.menuWrapper.find('.submenu-toggle[aria-controls="' + submenuId + '"]');
				button.attr('aria-expanded', 'false');
				button.attr('aria-checked', 'false');
			}
		);
	}

	/**
	 * Toggles the visibility and accessibility attributes of a sub-menu by its ID.
	 * Updates the button's aria-expanded and aria-checked attributes, and toggles
	 * the sub-menu's hidden and aria-hidden attributes for accessibility.
	 *
	 * This method is context-agnostic and only requires the sub-menu's ID.
	 *
	 * @param {string} submenuId - The ID of the sub-menu <ul> element.
	 */
	toggleSubmenu(submenuId) {
		const submenu = jQuery('#' + submenuId);
		const button = jQuery('.submenu-toggle[aria-controls="' + submenuId + '"]');

		if (submenu.length === 0 || button.length === 0) {
			return;
		}

		const isOpen = button.attr('aria-expanded') === 'true';

		// Update button ARIA states
		button.attr('aria-expanded', (!isOpen).toString());
		button.attr('aria-checked', (!isOpen).toString());

		// Toggle submenu visibility and accessibility
		if (isOpen) {
			submenu.attr('hidden', 'hidden');
			submenu.attr('aria-hidden', 'true');
		} else {
			submenu.removeAttr('hidden');
			submenu.attr('aria-hidden', 'false');
		}
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
