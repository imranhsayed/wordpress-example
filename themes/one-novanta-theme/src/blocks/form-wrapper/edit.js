/**
 * WordPress dependencies
 */
import {
	useBlockProps,
	RichText,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import MediaPreview from '../../js/block-components/media-preview';
import BlockControls from './block-controls';
import InspectorControls from './inspector-controls';

/**
 * External dependencies
 */
import classNames from 'classnames';

export default function Edit( { attributes, setAttributes } ) {
	const {
		template: blockTemplate,
		formAlignment,
		verticalAlign,
		reverseMobileOrder,
		heading,
		description,
		imageURL,
	} = attributes;

	const blockProps = useBlockProps( {
		className: classNames(
			'alignfull',
			'two-columns',
			`two-columns--vertical-align-${ verticalAlign }`,
			`two-columns--media-align-${ formAlignment }`,
			{
				'two-columns--reverse-order': reverseMobileOrder,
			},
		),
	} );

	const innerBlocksProps = useInnerBlocksProps(
		{},
		{
			templateLock: 'all',
			renderAppender: () => null,
			template: [
				[ 'gravityforms/form' ],
			],
		},
	);

	function setImage( image ) {
		setAttributes( {
			imageURL: image.url,
			imageID: image.id,
		} );
	}

	return (
		<>
			<BlockControls
				attributes={ attributes }
				setAttributes={ setAttributes }
				setImage={ setImage }
			/>
			<InspectorControls
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>
			<div { ...blockProps }>
				<div className="one-novanta-form-wrapper__content two-columns__column">
					{ blockTemplate === 'form' && (
						<>
							<RichText
								tagName="h2"
								value={ heading }
								onChange={ ( value ) =>
									setAttributes( { heading: value } )
								}
								allowedFormats={ [] }
								placeholder={ __(
									'Enter heading…',
									'one-novanta-theme',
								) }
								className="one-novanta-form-wrapper__heading has-xx-large-font-size"
							/>
							<RichText
								tagName="p"
								value={ description }
								onChange={ ( value ) =>
									setAttributes( { description: value } )
								}
								placeholder={ __(
									'Enter description…',
									'one-novanta-theme',
								) }
								className="one-novanta-form-wrapper__description has-medium-font-size"
							/>
						</>
					) }

					{ blockTemplate === 'form-with-media' && (
						<MediaPreview
							url={ imageURL }
							placeholderTitle={ __( 'Image', 'one-novanta-theme' ) }
							onSelect={ setImage }
							wrapperClassName="one-novanta-form-wrapper__media-placeholder"
							imgClassName="one-novanta-form-wrapper__image"
						/>
					) }
				</div>

				<div className="one-novanta-form-wrapper__form two-columns__column">
					<div { ...innerBlocksProps } />
				</div>
			</div>
		</>
	);
}
