class Tabs {

	elements = {};

	constructor(wrapper) {
		this.loadElements(wrapper);
		this.addAriaControls();
		this.setTabByHash();
		this.setTabActiveState();
		this.addEventListeners();
	}

	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.tab = wrapper.find('.tabs__tab');
		this.elements.pattern = wrapper.next().find('.tabs__pattern');
	}

	addAriaControls() {
		this.elements.tab.each(
			(index) => {
				const tab = this.elements.tab.eq(index);
				const pattern = this.elements.pattern.eq(index);

				tab.attr('aria-controls', pattern.attr('id'));
			}
		);
	}

	setTabByHash() {
		const hash = location.hash;

		if (!hash) {
			return;
		}

		this.elements.pattern.each(
			(index) => {
				const pattern = this.elements.pattern.eq(index);

				if (pattern.is(hash)) {
					this.setActiveTab(index);
					return false;
				}

				if (pattern.find(hash).length) {
					this.setActiveTab(index);
					return false;
				}
			}
		);
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
			(event) => {
				const tab = jQuery(event.currentTarget);
				const patternId = tab.attr('aria-controls');

				history.pushState({}, '', '#' + patternId);
				this.setTabByHash();
				this.setTabActiveState();
			}
		);

		window.addEventListener(
			'popstate',
			() => {
				this.setTabByHash();
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
