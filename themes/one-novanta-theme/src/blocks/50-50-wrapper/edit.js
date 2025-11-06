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
		imageAlignment,
		verticalAlign,
		reverseMobileOrder,
		heading,
		imageURL,
	} = attributes;

	const blockProps = useBlockProps( {
		className: classNames(
			'alignfull',
			'one-novanta-50-50-wrapper',
			'two-columns',
			`two-columns--vertical-align-${ verticalAlign }`,
			`two-columns--media-align-${ imageAlignment }`,
			{
				'two-columns--reverse-order': reverseMobileOrder,
			},
		),
	} );

	const innerBlocksProps = useInnerBlocksProps(
		{},
		{
			templateLock: false,
			renderAppender: () => null,
			template: [
				[
					'core/heading',
					{
						level: blockTemplate === 'question' ? 3 : 2,
						placeholder: __( 'Enter heading…', 'one-novanta-theme' ),
						fontSize: 'large',
					},
				],
				[
					'core/paragraph',
					{
						placeholder: __( 'Enter description…', 'one-novanta-theme' ),
					},
				],
				[ 'core/buttons', {}, [
					[
						'core/button',
						{
							text: __( 'Primary', 'one-novanta-theme' ),
							className: 'is-style-fill',
						},
					],
					[
						'core/button',
						{
							text: __( 'Secondary', 'one-novanta-theme' ),
							className: 'is-style-outline',
						},
					],
				] ],
			],
		},
	);

	const setImage = ( image ) => {
		setAttributes( {
			imageURL: image.url,
			imageID: image.id,
		} );
	};

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
				<div className="one-novanta-50-50-wrapper__content two-columns__column">
					{ blockTemplate === 'question' && (
						<RichText
							tagName="h2"
							value={ heading }
							onChange={ ( value ) =>
								setAttributes( { heading: value } )
							}
							placeholder={ __(
								'Enter heading…',
								'one-novanta-theme',
							) }
							allowedFormats={ [] }
							className="one-novanta-50-50-wrapper__heading has-xx-large-font-size"
						/>
					) }

					{ blockTemplate === 'content' && (
						<MediaPreview
							url={ imageURL }
							placeholderTitle={ __( 'Image', 'one-novanta-theme' ) }
							onSelect={ setImage }
							wrapperClassName="one-novanta-50-50-wrapper__media-placeholder"
							imgClassName="one-novanta-50-50-wrapper__image"
						/>
					) }
				</div>
				<div className="two-columns__column">
					<div { ...innerBlocksProps } />
				</div>
			</div>
		</>
	);
}
