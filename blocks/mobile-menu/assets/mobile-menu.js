class Mobile_Menu {

	elements = {};

	constructor(wrapper) {
		this.loadElements(wrapper);
		this.initializeToggle();
	}

	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.toggle = wrapper.find('.mobile-menu__toggle');
	}

	initializeToggle() {
		this.elements.toggle.on(
			'click',
			() => {
				this.toggle();
			}
		);
	}

	toggle() {
		jQuery(window).trigger('mobile_menu_toggle');
	}

	setToggleCheckedState(checked) {
		this.elements.toggle.attr('aria-checked', checked ? 'true' : 'false');
		this.elements.toggle.attr('aria-expanded', checked ? 'true' : 'false');
	}
}

jQuery(document).ready(
	() => {
		window.mobileMenu = [];

		let wrappers = jQuery('.mobile-menu__wrapper');

		wrappers.each(
			(index) => {
				window.mobileMenu.push(new Mobile_Menu(wrappers.eq(index)));
			}
		);
	}
);
