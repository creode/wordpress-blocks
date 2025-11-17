class AdminTableBlock {

	elements = {};

	constructor(main) {
		this.elements.main = main;
		this.setObserver();
		this.applyMatchHeight();
	}

	setObserver() {
		const observer = new MutationObserver(
			() => {
				this.applyMatchHeight();
			}
		);

		observer.observe(this.elements.main.get(0), { childList: true, subtree: true });
	}

	applyMatchHeight() {
		const tableCellContent = this.elements.main.find('.table__table-cell-content');

		tableCellContent.matchHeight({ remove: true });
		tableCellContent.matchHeight();
	}
}

new AdminBlockInitializer(
	'.table__main',
	function (main) {
		new AdminTableBlock(main);
	}
);
