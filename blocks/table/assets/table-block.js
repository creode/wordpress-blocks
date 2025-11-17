class TableBlock {

	elements = {};

	constructor(wrapper) {
		this.loadElements(wrapper);
		this.listenForVisibilityChanges();
		this.applyMatchHeight();
	}

	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.tableCellContent = wrapper.find('.table__table-cell-content');
	}

	listenForVisibilityChanges() {
		const visibilityStates = new WeakMap();
		const checker = () => {
			let hasChanged = false;
			this.elements.tableCellContent.each(
				(index) => {
					const tableCellContent = this.elements.tableCellContent.eq(index);
					const isVisible = tableCellContent.is(':visible');

					if (!hasChanged && visibilityStates.get(tableCellContent.get(0)) !== isVisible) {
						this.applyMatchHeight();
						hasChanged = true;
					}

					visibilityStates.set(tableCellContent.get(0), isVisible);
				}
			);
			requestAnimationFrame(checker);
		};
		requestAnimationFrame(checker);
	}

	applyMatchHeight() {
		this.elements.tableCellContent.matchHeight({ remove: true });
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
