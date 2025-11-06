/**
 * WordPress dependencies
 */
import { addFilter } from '@wordpress/hooks';

/**
 * Internal dependencies
 */
import meta from '../../blocks/section/block.json';

/**
 * Add section attributes to the block settings.
 * This allows us to add custom attributes to the block.
 *
 */
const ADD_SECTION_ATTRIBUTES_TO = [
	'one-novanta/tile-carousel',
	'one-novanta/tiles',
	'one-novanta/tabs',
	'one-novanta/featured-content',
	'one-novanta/related-wrapper',
	'one-novanta/featured-media-slider',
	'one-novanta/image-text-cards',
	'one-novanta/listing',
	'one-novanta/latest-news',
];

/**
 * Add section attributes to the block settings.
 * This allows us to add custom attributes to the block.
 *
 * @param {*}      settings Block settings.
 * @param {string} name     Block name.
 *
 * @return {*} settings Block settings with custom attributes.
 */
function addSectionAttributes( settings, name ) {
	if ( ADD_SECTION_ATTRIBUTES_TO.includes( name ) ) {
		settings.attributes = {
			...settings.attributes,
			...meta.attributes,
		};
	}
	return settings;
}

addFilter(
	'blocks.registerBlockType',
	'one-novanta/add-section-attributes',
	addSectionAttributes,
);

