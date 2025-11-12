class Tabs {

	elements = {};

	constructor(wrapper) {
		this.loadElements(wrapper);
		this.setTabActiveState();
		this.addEventListeners();
	}

	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.tab = wrapper.find('.tabs__tab');
		this.elements.pattern = wrapper.next().find('.tabs__pattern');
	}

	setTabActiveState() {
		this.elements.tab.removeClass('tabs__tab--active');
		this.elements.pattern.prop('hidden', true);
		this.elements.pattern.attr('aria-hidden', true);

		const index = this.elements.wrapper.data('active-tab');
		const tab = this.elements.tab.eq(index);
		const pattern = this.elements.pattern.eq(index);

		tab.addClass('tabs__tab--active');
		pattern.prop('hidden', false);
		pattern.attr('aria-hidden', false);
	}

	addEventListeners() {
		this.elements.tab.on(
			'click',
			() => {
				const index = this.elements.tab.index(event.currentTarget);
				this.setActiveTab(index);
				this.setTabActiveState();
			}
		);
	}

	setActiveTab(index) {
		this.elements.wrapper.data('active-tab', index);
	}
}

jQuery(document).ready(
	() => {
		const wrappers = jQuery('.tabs__wrapper');

		wrappers.each(
			(index) => {
				new Tabs(wrappers.eq(index));
			}
		);
	}
);
