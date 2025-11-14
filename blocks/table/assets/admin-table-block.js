class AdminTableBlock {

	elements = {};

	constructor(blockDiv) {
		this.elements.blockDiv = blockDiv;
		this.setObserver();
		this.applyMatchHeight();
	}

	setObserver() {
		const observer = new MutationObserver(
			() => {
				this.applyMatchHeight();
			}
		);

		observer.observe(this.elements.blockDiv.get(0), { childList: true, subtree: true });
	}

	applyMatchHeight() {
		const tableCellContent = this.elements.blockDiv.find('.table__table-cell-content');

		tableCellContent.matchHeight({ remove: true });
		tableCellContent.matchHeight();
	}
}

new AdminBlockInitializer(
	'.wp-block-acf-table',
	function (blockDiv) {
		new AdminTableBlock(blockDiv);
	}
);
