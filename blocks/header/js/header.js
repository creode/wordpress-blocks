class Header {

	breakpoint = 760;
	menuExpanded = false;
	elements = {};

	constructor(wrapper) {
		this.loadElements(wrapper);
		if(this.elements.menu.section.length) {
			this.setDefaultMenuExpandedValue();
			this.setMenuState();
			this.setFocusableMenuItems();
			this.setMenuEventListeners();
		}
	}

	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.menu = {};
		this.elements.menu.section = this.elements.wrapper.find('.header__section--menu');
		this.elements.menu.toggleWrapper = this.elements.wrapper.find('.header__menu-toggle-wrapper');
		this.elements.menu.toggle = this.elements.wrapper.find('.header__menu-toggle');
		this.elements.menu.closeButtonWrapper = this.elements.wrapper.find('.header__menu-close-button-wrapper');
		this.elements.menu.closeButton = this.elements.wrapper.find('.header__menu-close-button');
		this.elements.menu.wrapper = this.elements.wrapper.find('.header__menu-wrapper');
		this.elements.menu.inner = this.elements.wrapper.find('.header__menu-inner');
	}

	isDesktopScreen() {
		return this.breakpoint < window.innerWidth;
	}

	setDefaultMenuExpandedValue() {
		this.menuExpanded = this.isDesktopScreen();
	}

	setMenuState() {
		this.elements.menu.section.toggleClass('header__section--desktop-menu', this.isDesktopScreen());
		this.elements.menu.toggleWrapper.prop('hidden', this.isDesktopScreen());
		this.elements.menu.toggle.prop('checked', this.menuExpanded);
		this.isDesktopScreen() ? this.elements.menu.toggleWrapper.attr('aria-hidden', '') : this.elements.menu.toggleWrapper.removeAttr('aria-hidden');
		this.elements.menu.closeButtonWrapper.prop('hidden', this.isDesktopScreen());
		this.isDesktopScreen() ? this.elements.menu.closeButtonWrapper.attr('aria-hidden', '') : this.elements.menu.closeButtonWrapper.removeAttr('aria-hidden');
		this.elements.menu.wrapper.prop('hidden', ! this.menuExpanded);
		this.menuExpanded ? this.elements.menu.wrapper.removeAttr('aria-hidden') : this.elements.menu.wrapper.attr('aria-hidden', '');
	}

	setFocusableMenuItems() {
		let focusables = this.elements.menu.inner.get(0).querySelectorAll('a, button');

		for (let i = 0; i < focusables.length; i++) {
			focusables[i].tabIndex = this.menuExpanded ? 0 : -1;
		}
	}

	setMenuEventListeners() {
		jQuery(window).resize(
			() => {
				this.setDefaultMenuExpandedValue();
				this.setMenuState();
				this.setFocusableMenuItems();
			}
		);
		this.elements.menu.toggle.on(
			'change',
			() => {
				this.menuExpanded = ! this.menuExpanded;
				this.setMenuState();
				this.setFocusableMenuItems();
			}
		);
		this.elements.menu.toggle.on(
			'keyup',
			(event) => {
				if(event.originalEvent.key != 'Enter') {
					return;
				}
				this.menuExpanded = ! this.menuExpanded;
				this.setMenuState();
				this.setFocusableMenuItems();
			}
		);
		this.elements.menu.closeButton.on(
			'click',
			() => {
				this.menuExpanded = false;
				this.setMenuState();
				this.setFocusableMenuItems();
			}
		);
	}

};

jQuery('document').ready(
	() => {
		jQuery('.header__wrapper').each(
			function() {
				new Header(jQuery(this));
			}
		);
	}
);
