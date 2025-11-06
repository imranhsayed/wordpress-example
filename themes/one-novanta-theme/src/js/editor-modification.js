/**
 * WordPress dependencies
 */
import domReady from '@wordpress/dom-ready';
import { unregisterFormatType } from '@wordpress/rich-text';
import { getBlockVariations, unregisterBlockVariation } from '@wordpress/blocks';

const editorModification = {
	/**
	 * Globally disable RichText formatting options.
	 */
	unregisterCoreFormatTypes() {
		const formatsToUnregister = [
			'core/code',
			'core/image',
			'core/keyboard',
			'core/language',
			'core/strikethrough',
		];

		formatsToUnregister.forEach( ( format ) => {
			unregisterFormatType( format );
		} );
	},

	/**
	 * Unregister all Embed block variations.
	 */
	unregisterAllEmbedBlockVariations() {
		const blockName = 'core/embed';
		const allEmbedVariations = getBlockVariations( blockName );
		const excludedEmbedVariation = [ 'wistia', 'youtube' ];

		allEmbedVariations.forEach( ( variation ) => {
			// Exclude required Embeds.
			if ( excludedEmbedVariation.includes( variation.name ) ) {
				return;
			}

			unregisterBlockVariation( blockName, variation.name );
		} );
	},

	/**
	 * Unregister all One Novanta Section block variations.
	 */
	unregisterSectionBlockVariations() {
		/**
		 * oneNovantaEMVars is passed from Assets.php.
		 * select( 'core/editor' ).getCurrentPostType() was not used because it was returning null.
		 */
		// eslint-disable-next-line no-undef
		if ( oneNovantaEMVars?.postType !== 'product' ) {
			return;
		}

		const blockName = 'one-novanta/section';
		const allSectionVariations = getBlockVariations( blockName );

		// eslint-disable-next-line no-undef
		const excludedBlocks = oneNovantaEMVars?.filterBlocks?.product;

		allSectionVariations.forEach( ( variation ) => {
			// Exclude the block which should be present on product page.
			if ( excludedBlocks.includes( 'one-novanta/' + variation.name ) ) {
				return;
			}

			unregisterBlockVariation( 'one-novanta/section', variation.name );
		} );
	},
};

domReady( () => {
	editorModification.unregisterCoreFormatTypes();
	editorModification.unregisterAllEmbedBlockVariations();
	editorModification.unregisterSectionBlockVariations();
} );
