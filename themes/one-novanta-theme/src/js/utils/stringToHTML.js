/**
 * External dependencies
 */
import DOMPurify from 'dompurify';

/**
 * Converts string to HTML Node.
 * Note: Pass a container tag if the HTML string contains multiple top-level nodes.
 *
 * @param {string}      htmlString   HTML string.
 * @param {string|null} containerTag Wrapper tag name | null when no wrapper needed.
 *
 * @return {HTMLElement|null|undefined} DOM Node or null or undefined when failed to generate DOM Node.
 */
const convertStringToHTML = ( htmlString, containerTag = null ) => {
	const allowedTags = [ 'div', 'span', 'section', 'article' ];

	if ( containerTag && ! allowedTags.includes( containerTag ) ) {
		containerTag = 'div'; // Fallback to a safe default.
	}

	const parser = new DOMParser();

	// Sanitize the HTML string first.
	const sanitizedHTML = DOMPurify.sanitize(
		htmlString,
		{
			RETURN_DOM: false,
			ADD_TAGS: [ // custom elements.
				'one-novanta-theme-locale-switcher',
				'one-novanta-sort-dropdown',
				'one-novanta-toggle-search-filter-button',
				'rt-accordion',
				'rt-accordion-item',
				'rt-accordion-handle',
				'rt-accordion-content',
				'rt-slider',
				'rt-slider-track',
				'rt-slider-slides',
				'rt-slider-slide',
				'rt-slider-arrow',
				'rt-tabs',
				'rt-tabs-nav',
				'rt-tabs-nav-item',
				'rt-tabs-tab',
				'rt-lightbox',
				'rt-lightbox-close',
				'rt-lightbox-previous',
				'rt-lightbox-next',
				'rt-lightbox-content',
				'rt-lightbox-count',
				'rt-lightbox-trigger',
				'ati-media-lightbox',
				'template',
				'dialog',
				'ati-product-gallery',
				'ati-add-to-cart-button',
			],
			ADD_ATTR: [ // custom attributes.
				'expand-text',
				'collapse-text',
				'open-by-default',
				'aria-expanded',
				'expanded',
				'behavior',
				'total',
				'direction',
				'current-tab',
				'role',
				'aria-orientation',
				'role',
				'tabindex',
				'aria-selected',
				'active',
				'close-on-overlay-click',
				'swipe',
				'swipe-threshold',
				'format',
				'lightbox',
				'group',
				'data-product-id',
				'data-text',
				'data-added-text',
			],
		},
	);

	let doc;

	if ( containerTag ) {
		doc = parser.parseFromString(
			`<${ containerTag }>${ sanitizedHTML }</${ containerTag }>`,
			'text/html',
		);
	} else {
		doc = parser.parseFromString( sanitizedHTML, 'text/html' );
	}

	return doc?.body?.firstElementChild;
};

export default convertStringToHTML;
