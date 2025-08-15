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
		this.setFocusableStates();
		this.initializeToggle();            // Attach event listeners to the main menu toggle.
		this.initializeSubmenuToggles();    // Attach event listeners for sub-menu toggles.
		this.setSubMenuHeightCssVariable();
		jQuery(window).resize(()=>{ this.setSubMenuHeightCssVariable() });
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
	 * Triggers a global event to toggle the mobile menu's state.
	 * Separate scripts should listen for the 'mobile_menu_toggle' event and handle show/hide logic.
	 */
	toggle() {
		jQuery(window).trigger('mobile_menu_toggle');
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
				this.setMenuLevelCSSVariable(submenuId);
				this.setSubMenuHeightCssVariable();
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

		document.activeElement.blur();

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
				submenu.attr('data-active', 'false');

				// Update corresponding toggle button
				const button = this.elements.menuWrapper.find('.submenu-toggle[aria-controls="' + submenuId + '"]');
				button.attr('aria-expanded', 'false');
				button.attr('aria-checked', 'false');
			}
		);

		this.setFocusableStates();
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
		const subMenuParents = submenu.parents('.sub-menu');
		const button = this.elements.menuWrapper.find('.submenu-toggle[aria-controls="' + submenuId + '"]');

		if (submenu.length === 0 || button.length === 0) {
			return;
		}

		const isOpen = button.attr('aria-expanded') === 'true';

		// Update button ARIA states
		button.attr('aria-expanded', (!isOpen).toString());
		button.attr('aria-checked', (!isOpen).toString());

		// Ensure parent sub-menus are visible.
		subMenuParents.removeAttr('hidden');
		subMenuParents.attr('aria-hidden', 'false');

		// Toggle submenu visibility and accessibility
		if (isOpen) {
			submenu.attr('hidden', 'hidden');
			submenu.attr('aria-hidden', 'true');
			submenu.attr('data-active', 'false');

			// Activate parent sub-menu.
			const firstSubMenuParent = subMenuParents.first();
			const firstSubMenuParentToggle = this.elements.menuWrapper.find('.submenu-toggle[aria-controls="' + firstSubMenuParent.prop('id') + '"]');
			firstSubMenuParent.attr('data-active', 'true');
			firstSubMenuParentToggle.attr('aria-expanded', 'true');
			firstSubMenuParentToggle.attr('aria-checked', 'true');
		} else {
			submenu.removeAttr('hidden');
			submenu.attr('aria-hidden', 'false');
			submenu.attr('data-active', 'true');
		}

		this.setFocusableStates();
	}

	/**
	 * Sets the --menu-level CSS variable on the appropriate menu wrapper,
	 * reflecting the nesting level of the currently active (visible) sub-menu.
	 *
	 * @param {string} submenuId - The ID of the sub-menu <ul> element.
	 */
	setMenuLevelCSSVariable(submenuId) {
		this.elements.menuWrapper.each(
			(index) =>  {
				const menuWrapper = this.elements.menuWrapper.eq(index);

				if(!menuWrapper.find('#' + submenuId).length) {
					return;
				}

				this.setMenuWrapperCSSVariable('active-menu-level', this.getMenuLevel(menuWrapper), index);
			}
		);
	}

	/**
	 * Determines the nesting level (depth) of the currently active sub-menu within a given menu wrapper.
	 * Level 0 = top-level menu, 1 = first sub-menu, etc.
	 *
	 * @param {jQuery} menuWrapper - The jQuery object for the menu wrapper.
	 * @returns {number} The nesting level (integer, 0 or greater). Returns 0 if no active submenu is found.
	 */
	getMenuLevel(menuWrapper) {
		// Find the first visible submenu within this wrapper
		const submenu = menuWrapper.find('ul[id^="sub-menu-"][data-active="true"]').first();

		if (!submenu.length) {
			return 0;
		}

		let level = 1;
		let current = submenu;

		while (
			current.length &&
			!current.parent().is(menuWrapper)
		) {
			current = current.parent().closest('ul[id^="sub-menu-"]');
			if (current.length) {
				level++;
			}
		}
		return level;
	}

	/**
	 * For each menuWrapper, this calculates the height of it's tallest sub-menu.
	 * It assigns this value to menuWrapper element's height-of-tallest-sub-menu CSS variable.
	 */
	setSubMenuHeightCssVariable() {
		this.elements.menuWrapper.each(
			(index) => {
				const menuWrapper = this.elements.menuWrapper.eq(index);
				const subMenus = menuWrapper.find('.sub-menu');
				let greatestHeight = 0;

				subMenus.each(
					(index) => {
						const subMenu = subMenus.eq(index);
						const height = subMenu.outerHeight();

						if (height <= greatestHeight) {
							return;
						}

						greatestHeight = height;
					}
				);

				this.setMenuWrapperCSSVariable('height-of-tallest-sub-menu', greatestHeight, index);
			}
		);
	}

	/**
	 * Ensures that focusable elements within non-active menus are inert.
	 * Ensures that focusable elements eithin active menus are not inert.
	 */
	setFocusableStates() {
		this.elements.menuWrapper.each(
			(index) => {
				const menuWrapper = this.elements.menuWrapper.eq(index);

				menuWrapper.find('a, button').prop('inert', true);

				let activeMenu = menuWrapper.children('ul');
				const activeSubMenu = menuWrapper.find('.sub-menu[data-active="true"]');

				if (activeSubMenu.length) {
					activeMenu = activeSubMenu;
				}

				activeMenu.children('li').children('a, button').prop('inert', false);
			}
		);
	}

	/**
	 * Sets a CSS variable on a menu wrapper element, or all wrappers if no index is provided.
	 *
	 * @param {string} variableName - The CSS variable name (without the '--' prefix, e.g., 'menu-level').
	 * @param {string|number} value - The value to assign to the CSS variable.
	 * @param {number} [menuWrapperIndex] - (Optional) The index of the menu wrapper within the page.
	 */
	setMenuWrapperCSSVariable(variableName, value, menuWrapperIndex) {
		let menuWrapper = this.elements.menuWrapper;

		if (typeof menuWrapperIndex !== 'undefined') {
			menuWrapper = this.elements.menuWrapper.eq(menuWrapperIndex);
		}

		menuWrapper.css('--' + variableName, value);
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
