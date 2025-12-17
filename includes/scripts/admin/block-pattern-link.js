/**
 * Handles the opening of the block pattern link to the site editor.
 *
 * @package Creode Blocks
 */

jQuery( document ).on(
	'click',
	'.block-pattern-link',
	(event) => {
		event.preventDefault();

		const target =jQuery(event.target);

		if ( target.hasClass( 'block-pattern-link' ) ) {
			var link = target;
		} else {
			var link = target.closest( '.block-pattern-link' );
		}

		window.open(link.attr( 'data-href' ), '_blank');
	}
);
