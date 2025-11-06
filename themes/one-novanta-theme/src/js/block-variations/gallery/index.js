/**
 * WordPress dependencies
 */
import { InspectorControls } from '@wordpress/block-editor';
import { getBlockType, registerBlockVariation } from '@wordpress/blocks';
import { createHigherOrderComponent } from '@wordpress/compose';
import domReady from '@wordpress/dom-ready';
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';

const BLOCK_SIZE_SLUG = 'novanta-logo-plate';
const HIDE_SETTINGS_CSS = `
	.block-editor-block-inspector__tabs div[id^="tabs"][id*="settings-view"] > div:first-child {
		display: none;
	}
`;

domReady( () => {
	// Get the core/gallery block.
	const galleryBlock = getBlockType( 'core/gallery' );

	// If the gallery block is registered, enable the className support.
	if ( galleryBlock ) {
		galleryBlock.supports.className = true;
	}

	// Register a custom block variation for the core/gallery block
	registerBlockVariation(
		'core/gallery',
		{
			name: 'novanta-logo-plate',
			title: __( 'Logo Plate', 'one-novanta-theme' ),
			description: __(
				'A gallery using the small Logo Plate image size.',
				'one-novanta-theme',
			),
			category: 'one-novanta',
			attributes: {
				// Keep the image size slug for the Logo Plate size since this variation will only be used for that size.
				sizeSlug: BLOCK_SIZE_SLUG,
				// Set the number of columns for the Logo Plate size to 5.
				columns: 5,
				align: 'wide',
				className: 'novanta-logo-plate-wrapper',
			},
			isActive: ( blockAttributes ) => {
				return blockAttributes.sizeSlug === BLOCK_SIZE_SLUG;
			},
		},
	);
} );

// Higher-Order Component to wrap the BlockEdit component.
const withConditionalSettingsHide = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		// Only apply to the core/gallery block
		if ( props.name !== 'core/gallery' ) {
			return <BlockEdit { ...props } />;
		}

		// Check if the block is selected and if it's the Logo Plate variation
		const { attributes, isSelected } = props;
		const isLogoPlate = attributes?.sizeSlug === BLOCK_SIZE_SLUG; // Check the attribute

		return (
			<>
				{ /* Render the original block editor component */ }
				<BlockEdit { ...props } />

				{ isSelected && isLogoPlate && (
					<InspectorControls>
						<style dangerouslySetInnerHTML={ { __html: HIDE_SETTINGS_CSS } } />
					</InspectorControls>
				) }
			</>
		);
	};
}, 'withConditionalSettingsHide' );

// Apply the HOC to the BlockEdit component.
addFilter(
	'editor.BlockEdit',
	'one-novanta-theme/hide-gallery-logo-plate-settings', // Unique namespace
	withConditionalSettingsHide,
);
