class TableBlock {

	elements = {};

	constructor(wrapper) {
		this.loadElements(wrapper);
		this.applyMatchHeight();
	}

	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.tableCellContent = wrapper.find('.table__table-cell-content');
	}

	applyMatchHeight() {
		this.elements.tableCellContent.matchHeight();
	}
}

jQuery(document).ready(
	() => {
		const wrappers = jQuery('.table__wrapper');

		wrappers.each(
			(index) => {
				new TableBlock(wrappers.eq(index));
			}
		);
	}
);
