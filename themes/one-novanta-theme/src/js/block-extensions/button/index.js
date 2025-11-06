/**
 * Core Button block extend.
 */

/**
 * WordPress dependencies
 */
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { ToggleControl, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { InspectorControls } from '@wordpress/block-editor';
import { useEffect } from '@wordpress/element';

/**
 * Add additional attribute in core blocks.
 *
 * @param {Object} settings Settings for the block.
 * @param {string} name     Name of block.
 *
 * @return {Object} settings Modified settings.
 */
const extendAttributes = ( settings, name ) => {
	if ( 'core/button' !== name ) {
		return settings;
	}

	settings.attributes = {
		...settings.attributes,
		hasArrow: {
			type: 'boolean',
			default: true,
		},
	};

	return settings;
};

/**
 * Higher order component with inspector controls for extending core block.
 *
 * @param {string} name Name of block.
 *
 * @return {JSX} Updated edit block.
 */
const extendControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( 'core/button' !== props.name ) {
			return (
				<BlockEdit { ...props } />
			);
		}

		const { attributes, setAttributes } = props;
		const { hasArrow } = attributes;

		useEffect( () => {
			const classes = ( props?.attributes?.className ?? '' )
				.split( ' ' )
				.filter( ( item ) => 'has-arrow' !== item );

			if ( hasArrow ) {
				classes.push( 'has-arrow' );
			}

			setAttributes( { className: classes.filter( Boolean ).join( ' ' ) } );
		}, [ hasArrow ] );

		return (
			<>
				<BlockEdit { ...props } />

				<InspectorControls>
					<PanelBody title={ __( 'One Novanta Button Options', 'one-novanta-theme' ) }>
						<ToggleControl
							label={ __( 'Has Icon', 'one-novanta-theme' ) }
							checked={ hasArrow }
							onChange={ ( value ) => setAttributes( { hasArrow: value } ) }
						/>
					</PanelBody>
				</InspectorControls>
			</>
		);
	};
} );

addFilter( 'blocks.registerBlockType', 'one-novanta-theme/extend-core-button', extendAttributes );
addFilter( 'editor.BlockEdit', 'one-novanta-theme/extend-core-button', extendControls );
