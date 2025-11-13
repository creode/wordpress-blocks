class Tabs extends AdminBlock {

	setup() {
		this.setActiveTab(parseInt(this.getAttribute('active_tab')));
		this.setEventListeners();
	}

	setEventListeners() {
		this.blockDiv.on(
			'click',
			'.tabs__tab',
			(event) => {
				const index = this.blockDiv.find('.tabs__tab').index(event.currentTarget);

				this.capturePatterns();
				this.setActiveTab(index);
			}
		);

		this.addListener(
			(path, originalValue, newValue) => {
				// Check if path matches pattern: innerBlocks[n].attributes.data.field_tabs_block_pattern
				const regex = /^innerBlocks\[\d+\]\.attributes\.data\.field_tabs_block_pattern$/;
				if (!regex.test(path)) {
					return;
				}

				this.capturePatterns();
			}
		);
	}

	setActiveTab(index) {
		this.blockDiv.find('.tabs__tab').removeClass('tabs__tab--active');
		this.blockDiv.find('.tabs__tab').eq(index).addClass('tabs__tab--active');
		this.setAttribute('active_tab', index);
	}

	capturePatterns() {
		this.loadBlock();

		let patterns = [];

		for (const i in this.block.innerBlocks) {
			patterns[i] = '';
			if (typeof this.block.innerBlocks[i].attributes == 'undefined') {
				continue;
			}
			if (typeof this.block.innerBlocks[i].attributes.data == 'undefined') {
				continue;
			}
			if (typeof this.block.innerBlocks[i].attributes.data.field_tabs_block_pattern !== 'undefined') {
				patterns[i] = this.block.innerBlocks[i].attributes.data.field_tabs_block_pattern;
			}
			if (typeof this.block.innerBlocks[i].attributes.data.pattern !== 'undefined') {
				patterns[i] = this.block.innerBlocks[i].attributes.data.pattern;
			}
		}

		this.setAttribute('patterns', patterns.join(','));
	}
}

new AdminBlockInitializer(
	'.wp-block-acf-tabs',
	(blockDiv) => {
		window.mytest = new Tabs(blockDiv);
	}
);
