(function() {
	'use strict';

	const selectors = [
		'.table__table-cell-content'
	];

	// Function to apply matchHeight to all elements matching selectors
	function applyMatchHeight() {
		const elements = jQuery(selectors.join(', '));

		// Remove existing matchHeight to prevent duplication
		elements.matchHeight({ remove: true });
		// Apply matchHeight to all matching elements
		elements.matchHeight();
	}

	jQuery(document).ready(
		() => {
			applyMatchHeight();

			const observer = new MutationObserver(
				() => {
					applyMatchHeight();
				}
			);

			observer.observe(document.body, {childList: true, subtree: true});
		}
	);
})();
