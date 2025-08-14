/**
 * Class representing a site header component with accessibility and mobile menu support.
 *
 * This class ensures that each header instance is uniquely identified, manages ARIA and inert
 * attributes for accessibility, and sets up event listeners for responsive and accessible
 * mobile menu toggling.
 */
class Site_Header {

	/**
	 * Unique instance number for this header, used to generate unique IDs for internal elements.
	 * @type {number|null}
	 */
	instanceNumber = null;

	/**
	 * Stores jQuery references to important DOM elements in the header.
	 * @type {Object}
	 * @property {jQuery} wrapper - The main header wrapper element.
	 * @property {jQuery} mobileMenuToggle - The mobile menu toggle button.
	 * @property {jQuery} mobileMenuWrapper - The mobile menu wrapper element.
	 */
	elements = {};

	/**
	 * Create a Site_Header instance.
	 * @param {jQuery} wrapper - The jQuery-wrapped root element for the site header instance.
	 */
	constructor(wrapper) {
		this.setInstanceNumber();
		this.loadElements(wrapper);
		this.assignHiddenAttributes();
		jQuery(window).resize(() => {this.assignHiddenAttributes()});
		this.initializeMobileMenu();
		this.activate();
	}

	/**
	 * Sets a unique instance number for this header instance.
	 * This is used to generate unique IDs for elements such as the mobile menu.
	 * The number is stored on the global window object to ensure uniqueness across instances.
	 */
	setInstanceNumber() {
		if (typeof window.headerCount == 'undefined') {
			window.headerCount = -1;
		}

		window.headerCount++;
		this.instanceNumber = window.headerCount;
	}

	/**
	 * Loads and stores key DOM elements for this instance.
	 * @param {jQuery} wrapper - The jQuery-wrapped root element for the site header instance.
	 */
	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.mobileMenuToggle = wrapper.find('.site-header__mobile-menu-toggle');
		this.elements.mobileMenuWrapper = wrapper.find('.site-header__mobile-menu-wrapper');
	}

	/**
	 * Assigns `aria-hidden` and `inert` attributes to specific elements based on their visibility.
	 *
	 * This method ensures that assistive technology (such as screen readers) correctly ignores 
	 * elements that are not visually visible to users. It uses a visibility check relying on 
	 * layout and computed style support (via `hasLayoutSupport`). If this support is not present,
	 * the function halts to avoid incorrectly marking all elements as hidden.
	 *
	 * For each target element:
	 *   - If the element is not visible (`:visible` is false), it assigns `aria-hidden="true"` 
	 *     and sets the `inert` property to `true`.
	 *   - If the element is visible, it removes the `aria-hidden` attribute and sets the `inert` 
	 *     property to `false`.
	 */
	assignHiddenAttributes() {
		// Define selectors for elements whose visibility should control ARIA/inert state.
		let selectors = [
			'.site-header__section--desktop-menu',
			'.site-header__section--mobile-menu-toggle',
			'.site-header__mobile-menu-outer-wrapper'
		];

		// Find all target elements within the wrapper.
		let elements = this.elements.wrapper.find(selectors.join(', '));

		// Prevent further execution if layout and computed style support is not available.
		// This avoids marking all elements as hidden when the environment cannot determine visibility.
		if (!this.helpers.hasLayoutSupport()) {
			return;
		}

		elements.each(
			(index) => {
				let element = elements.eq(index);

				// If the element is not visible, mark it as hidden for assistive technology.
				if ( ! element.is(':visible') ) {
					element.attr('aria-hidden', 'true');
					element.prop('inert', true);
					return;
				}

				// If visible, remove hidden attributes/properties.
				element.removeAttr('aria-hidden');
				element.prop('inert', false);
			}
		);
	}

	/**
	 * Initializes the mobile menu functionality for this header instance.
	 *
	 * - Sets a unique ID on the mobile menu wrapper and links it to the toggle button via `aria-controls`.
	 * - Attaches click event listeners for toggling the mobile menu.
	 * - Listens for a custom 'mobile_menu_toggle' event on the window.
	 */
	initializeMobileMenu() {
		let id = 'header-mobile-menu-wrapper-' + this.instanceNumber;

		this.elements.mobileMenuToggle.attr('aria-controls', id);
		this.elements.mobileMenuWrapper.prop('id', id);

		this.elements.mobileMenuToggle.on(
			'click',
			() => {
				this.toggleMobileMenu();
			}
		);

		this.elements.mobileMenuWrapper.on(
			'click',
			(event) => {
				if(!this.elements.mobileMenuWrapper.is(event.target)) {
					return;
				}

				this.toggleMobileMenu();
			}
		);

		jQuery(window).on(
			'mobile_menu_toggle',
			() => {
				this.toggleMobileMenu();
			}
		);
	}

	/**
	 * Toggles the visibility and ARIA/inert attributes of the mobile menu.
	 * 
	 * This method:
	 * - Updates `aria-checked` and `aria-expanded` on the toggle button.
	 * - Shows/hides the menu wrapper with `hidden`, `aria-hidden`, and `inert`.
	 */
	toggleMobileMenu() {
		let checked = this.elements.mobileMenuToggle.attr('aria-checked') == 'true' ? true : false;

		checked = ! checked;

		this.elements.mobileMenuToggle.attr('aria-checked', checked ? 'true' : 'false');
		this.elements.mobileMenuToggle.attr('aria-expanded', checked ? 'true' : 'false');
		document.activeElement.blur();
		this.elements.mobileMenuWrapper.prop('inert', ! checked);
		this.elements.mobileMenuWrapper.prop('hidden', ! checked);
		this.elements.mobileMenuWrapper.attr('aria-hidden', checked ? 'false' : true);
	}

	/**
	 * Adds the 'site-header__wrapper--active' class to the wrapper after initialization.
	 * This can be used in CSS to make the header opaque or trigger other visual changes.
	 */
	activate() {
		this.elements.wrapper.addClass('site-header__wrapper--active');
	}

	/**
	 * Helper functions for the Site_Header class.
	 * @type {Object}
	 */
	helpers = {
		/**
		 * Checks if the environment supports layout and computed style features needed
		 * for determining element visibility as browsers do.
		 *
		 * Specifically, verifies:
		 *  - window.getComputedStyle is available and functional
		 *  - offsetWidth reflects the element's width
		 *  - getClientRects() returns at least one rect for a visible element
		 *
		 * @returns {boolean} True if layout and computed style features are supported; otherwise, false.
		 */
		hasLayoutSupport: () => {
			// Ensure getComputedStyle exists and is a function.
			if (typeof window.getComputedStyle !== 'function') return false;
	
			// Create a visible test element with explicit size.
			var el = document.createElement('div');
			el.style.display = 'block';
			el.style.width = '10px';
			el.style.height = '10px';
			document.body.appendChild(el);
	
			// Check for correct computed style, offsetWidth, and getClientRects support.
			var result =
					window.getComputedStyle(el).width === '10px' &&          // CSS width is correctly reported
					el.offsetWidth === 10 &&                                 // offsetWidth reflects the set width
					typeof el.getClientRects === 'function' &&               // getClientRects exists
					el.getClientRects().length > 0;                          // getClientRects returns at least one rect
	
			// Clean up the test element.
			document.body.removeChild(el);
	
			return result;
		}
	}
}

/**
 * On document ready, initialize a Site_Header instance for each `.site-header__wrapper` element.
 * Each instance is stored globally in window.siteHeader.
 */
jQuery(document).ready(
	() => {
		window.siteHeader = [];

		let wrappers = jQuery('.site-header__wrapper');

		wrappers.each(
			(index) => {
				window.siteHeader.push(new Site_Header(wrappers.eq(index)));
			}
		);
	}
);
