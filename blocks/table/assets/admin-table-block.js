class AdminTableBlock {

	elements = {};

	constructor(main) {
		this.elements.main = main;
		this.setObserver();
		this.listenForVisibilityChanges();
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

	listenForVisibilityChanges() {
		const visibilityStates = new WeakMap();
		const checker = () => {
			const tableCellContents = this.elements.main.find('.table__table-cell-content');
			let hasChanged = false;
		
			tableCellContents.each(
				(index) => {
					const tableCellContent = tableCellContents.eq(index);
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
