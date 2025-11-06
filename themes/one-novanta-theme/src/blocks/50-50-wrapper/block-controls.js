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
	const { imageID, imageURL, imageAlignment, template, verticalAlign } =
		attributes;

	return (
		<BaseBlockControls>
			<BlockVerticalAlignmentToolbar
				value={ verticalAlign }
				onChange={ ( value ) => setAttributes( { verticalAlign: value } ) }
			/>
			<AlignmentToolbar
				value={ imageAlignment }
				onChange={ ( value ) => setAttributes( { imageAlignment: value } ) }
				labels={ template === 'question' ? {
					left: __( 'Align Heading Left', 'one-novanta-theme' ),
					right: __( 'Align Heading Right', 'one-novanta-theme' ),
				} : {
					left: __( 'Align Image Left', 'one-novanta-theme' ),
					right: __( 'Align Image Right', 'one-novanta-theme' ),
				} }
			/>

			{ template === 'content' && (
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
					noticeId="50-50-media-upload-error"
				/>
			) }
		</BaseBlockControls>
	);
}
