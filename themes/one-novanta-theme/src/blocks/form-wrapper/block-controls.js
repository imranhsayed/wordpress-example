/**
 * WordPress dependencies
 */
import {
	BlockControls as BaseBlockControls,
	BlockVerticalAlignmentToolbar,
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import AlignmentToolbar from '../../js/block-components/alignment-toolbar';
import MediaControls from '../../js/block-components/media-controls';

export default function BlockControls( { attributes, setAttributes, setImage } ) {
	const { imageID, imageURL, formAlignment, template } = attributes;

	return (
		<BaseBlockControls>
			<BlockVerticalAlignmentToolbar
				value={ attributes.verticalAlign }
				onChange={ ( value ) => setAttributes( { verticalAlign: value } ) }
			/>
			<AlignmentToolbar
				value={ formAlignment }
				onChange={ ( value ) => setAttributes( { formAlignment: value } ) }
				labels={ template === 'form-with-media' ? {
					left: __( 'Align Image Left', 'one-novanta-theme' ),
					right: __( 'Align Image Right', 'one-novanta-theme' ),
				} : {
					left: __( 'Align Content Left', 'one-novanta-theme' ),
					right: __( 'Align Content Right', 'one-novanta-theme' ),
				} }
			/>
			{ template === 'form-with-media' && (
				<MediaControls
					imageID={ imageID }
					imageURL={ imageURL }
					onSelectMedia={ setImage }
					onResetMedia={ () => {
						setAttributes( {
							imageURL: undefined,
							imageID: undefined,
						} );
					} }
					noticeId="form-media-upload-error"
				/>
			) }
		</BaseBlockControls>
	);
}
