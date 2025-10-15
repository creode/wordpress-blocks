class PostListing {

	elements = {};

	constructor(wrapper) {
		this.loadElements(wrapper);
		this.addHashToPaginationLinks();
	}

	loadElements(wrapper) {
		this.elements.wrapper = wrapper;
		this.elements.queryWrapper = wrapper.find('.post-listing__query-wrapper');
		this.elements.paginationWrapper = wrapper.find('.wp-block-query-pagination');
	}

	addHashToPaginationLinks() {
		const id = this.elements.queryWrapper.prop('id');
		const anchors = this.elements.paginationWrapper.find('a');

		anchors.each(
			(index) => {
				const anchor = anchors.eq(index);
				let url = new URL(anchor.prop('href'));

				url.hash = id;
				anchor.prop('href', url.toString());
			}
		);
	}
}

jQuery(document).ready(
	() => {
		const wrappers = jQuery('.post-listing__wrapper');
		wrappers.each(
			(index) => {
				new PostListing(wrappers.eq(index));
			}
		);
	}
);
