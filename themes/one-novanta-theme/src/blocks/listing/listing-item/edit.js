/**
 * WordPress dependencies
 */
import { BlockControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import MediaControls from '../../../js/block-components/media-controls';
import fallBackImage from '../../../img/default_image.png';

/**
 * Editor side of the block.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const {
		imageID,
		imageURL,
		imageAlt,
	} = attributes;

	// Block props.
	const blockProps = useBlockProps( {
		className: 'listing-card',
	} );

	const innerBlockProps = useInnerBlocksProps( {}, {
		template: [
			[
				'core/heading',
				{
					level: 3,
					placeholder: __( 'Add heading…', 'one-novanta-theme' ),
					fontSize: 'large',
				},
			],
			[
				'core/paragraph',
				{
					placeholder: __( 'Add description…', 'one-novanta-theme' ),
					fontSize: 'normal',
				},
			],
		],
		allowedBlocks: [ 'core/heading', 'core/paragraph', 'core/list' ],
		templateLock: 'false',
	} );

	const resetMediaHandler = () => {
		setAttributes( {
			imageURL: '',
			imageID: 0,
			imageAlt: '',
		} );
	};

	const imageContent = () => {
		if ( imageURL ) {
			return <img src={ imageURL } alt={
				imageAlt ?? __( 'Media & Text image', 'one-novanta-theme' )
			} />;
		}

		return <img src={ fallBackImage } alt={ __( 'Media & Text Fallback image', 'one-novanta-theme' ) } />;
	};

	return <>
		<BlockControls>
			<MediaControls
				imageID={ imageID }
				imageURL={ imageURL }
				onSelectMedia={ ( media ) =>
					setAttributes( {
						imageID: media.id,
						imageURL: media.url,
						imageAlt: media.alt,
					} )
				}
				onResetMedia={ resetMediaHandler }
			/>
		</BlockControls>
		<div { ...blockProps }>
			<figure className="listing-card__image-wrap">
				{ imageContent() }
			</figure>

			<div className="listing-card__content">
				<div { ...innerBlockProps } />
			</div>
		</div>
	</>;
}
