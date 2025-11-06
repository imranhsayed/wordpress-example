/**
 * WordPress dependencies
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { BlockControls, MediaReplaceFlow } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { useDispatch } from '@wordpress/data';
import { store as noticesStore } from '@wordpress/notices';

/**
 * Add section attributes to the block settings.
 * This allows us to add custom attributes to the block.
 *
 */
const ADD_SECTION_ATTRIBUTES_TO = [
	'core/embed',
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
			posterImageId: {
				type: 'number',
				default: 0,
			},
			posterImageUrl: {
				type: 'string',
				default: '',
			},
		};
	}
	return settings;
}

addFilter(
	'blocks.registerBlockType',
	'one-novanta/add-section-attributes',
	addSectionAttributes,
);

/**
 * Add option to set poster image for embed block.
 */
const withMyPluginControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! ADD_SECTION_ATTRIBUTES_TO.includes( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props;
		const { posterImageId, posterImageUrl } = attributes;
		const { id, url } = posterImageId ? { id: posterImageId, url: posterImageUrl } : { id: undefined, url: undefined };

		const { createErrorNotice } = useDispatch( noticesStore );
		function onUploadError( message ) {
			createErrorNotice( message, { type: 'snackbar' } );
			setAttributes( {
				src: undefined,
				id: undefined,
				url: undefined,
				blob: undefined,
			} );
		}

		return (
			<>
				<BlockEdit key="edit" { ...props } />
				<BlockControls group="other">
					<MediaReplaceFlow
						mediaId={ id }
						mediaURL={ url }
						allowedTypes={ [ 'image' ] }
						accept="image/*"
						onSelect={ ( media ) => {
							setAttributes( {
								posterImageId: media.id,
								posterImageUrl: media.url,
							} );
						} }
						onError={ onUploadError }
						name={ ! url ? __( 'Add poster image' ) : __( 'Replace poster' ) }
						onReset={ () => {
							setAttributes( {
								posterImageId: undefined,
								posterImageUrl: undefined,
							} );
						} }
					/>
				</BlockControls>
			</>
		);
	};
}, 'withMyPluginControls' );

wp.hooks.addFilter(
	'editor.BlockEdit',
	'my-plugin/with-inspector-controls',
	withMyPluginControls,
);

