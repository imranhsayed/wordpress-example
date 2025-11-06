/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	InspectorControls as BaseInspectorControls,
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	TextControl,
} from '@wordpress/components';

export default function InspectorControls( { mediaType, mediaURL, setAttributes } ) {
	return (
		<BaseInspectorControls>
			<PanelBody title={ __( 'Settings', 'one-novanta-theme' ) }>
				<SelectControl
					label={ __( 'Media Type', 'one-novanta-theme' ) }
					value={ mediaType }
					options={ [
						{ label: __( 'Image', 'one-novanta-theme' ), value: 'image' },
						{ label: __( 'Wistia Video', 'one-novanta-theme' ), value: 'wistia' },
					] }
					onChange={ ( value ) =>
						setAttributes( {
							mediaType: value,
							imageID: 0,
							mediaURL: '',
							videoThumbnailID: 0,
							videoThumbnailURL: '',
						} )
					}
				/>
				<TextControl
					label={ __( 'Media URL', 'one-novanta-theme' ) }
					value={ mediaURL }
					onChange={ ( value ) => setAttributes( { mediaURL: value } ) }
				/>
			</PanelBody>
		</BaseInspectorControls>
	);
}
