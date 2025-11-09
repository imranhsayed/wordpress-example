/**
 * External dependencies
 */
import classNames from 'classnames';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { link as linkIcon } from '@wordpress/icons';
import { useEffect, useRef } from '@wordpress/element';
import { ToolbarButton, ToolbarGroup, Popover } from '@wordpress/components';
import {
	useBlockProps,
	RichText,
	BlockControls,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- Reason WP internally uses LinkControl in paragraph and other blocks.
	__experimentalLinkControl as LinkControl,
	store as blockEditorStore,
} from '@wordpress/block-editor';
import { useSelect, useDispatch } from '@wordpress/data';

/**
 * Internal dependencies
 */
import MediaControls from '@/block-components/MediaControls';
import MediaPreview from '@/block-components/MediaPreview';

/**
 * ArrowRightSVG JSX Component.
 */
const ArrowRightSVG = () => (
	<svg
		width="8"
		height="12"
		fill="currentColor"
		xmlns="http://www.w3.org/2000/svg"
	>
		<path
			d="M0 10.59 4.58 6 0 1.41 1.41 0l6 6-6 6L0 10.59z"
			fill="currentColor"
		/>
	</svg>
);

/**
 * Editor side of the block.
 *
 * @param {Object}  props               Block Props.
 * @param {Object}  props.context       Block context.
 * @param {Object}  props.attributes    Block Attributes.
 * @param {Object}  props.setAttributes Block Attributes setter method.
 * @param {Object}  props.clientId      A unique identifier assigned to each block instance.
 *
 * @param {boolean} props.isSelected
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( {
	attributes,
	setAttributes,
	context,
	clientId,
	isSelected,
} ) {
	// Show LinkControl near card.
	const cardRef = useRef();
	const {
		imageID,
		imageURL,
		imageAlt,
		link: cardLink,
		linkMeta,
	} = attributes;

	const editMode = context[ 'aquila/editMode' ] ?? true;
	const imageRatio = context[ 'aquila/imageRatio' ] ?? '';
	const imageSize = context[ 'aquila/imageSize' ] ?? '';

	// Set image ratio and size as attributes, to be used in render.php.
	useEffect( () => {
		setAttributes( { imageSize, imageRatio } );
	}, [ imageSize, imageRatio, setAttributes ] );

	// Get select/dispatch functions for block operations
	const { getBlockParents, getBlockName } = useSelect(
		( select ) => ( {
			getBlockParents: select( blockEditorStore ).getBlockParents,
			getBlockName: select( blockEditorStore ).getBlockName,
		} ),
		[],
	);

	const { selectBlock } = useDispatch( blockEditorStore );

	// Move focus to parent carousel block when edit mode is disabled
	useEffect( () => {
		if ( ! editMode && isSelected ) {
			// Get parent block ID (should be the tile-carousel)
			const parentBlockIds = getBlockParents( clientId );

			if ( parentBlockIds.length > 0 ) {
				const immediateParentId = parentBlockIds[ parentBlockIds.length - 1 ];
				const parentBlockName = getBlockName( immediateParentId );

				// Only redirect if parent is the carousel block
				if ( parentBlockName === 'aquila/tile-carousel' ) {
					// We use requestAnimationFrame to ensure this happens after the selection
					requestAnimationFrame( () => {
						selectBlock( immediateParentId );
					} );
				}
			}
		}
	}, [ clientId, editMode, getBlockParents, getBlockName, selectBlock, isSelected ] );

	const extraClasses = [];

	// Set the image ratio classes based on the imageRatio attribute.
	switch ( imageRatio ) {
		case '2:1':
			extraClasses.push( 'image-tile--two-one' );
			break;
		case '3:2':
			extraClasses.push( 'image-tile--three-two' );
			break;
		case '16:9':
			extraClasses.push( 'image-tile--sixteen-nine' );
			break;
		default:
			extraClasses.push( 'image-tile--one-one' );
			break;
	}

	// Set the image size classes based on the imageSize attribute, in the blockProps itself.
	const blockProps = useBlockProps( {
		className: classNames( 'image-tile', extraClasses ),
	} );

	const setMediaHandler = ( media ) => {
		// If no media is selected, return early.
		if ( ! media ) {
			return;
		}

		/**
		 * Prepare media url.
		 * Note: This Media parameter only have default image sizes.
		 * Custom image size are not present, therefore we are using large.
		 */
		const mediaUrl = media?.sizes?.large?.url || media?.url || null;

		setAttributes( {
			imageURL: mediaUrl,
			imageID: media?.id ?? 0,
			imageAlt: media?.alt_text ?? '',
		} );
	};

	const resetMediaHandler = () => {
		setAttributes( {
			imageURL: '',
			imageID: 0,
			imageAlt: '',
		} );
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						icon={ linkIcon }
						onClick={ () =>
							setAttributes( {
								showURLInput: ! attributes.showURLInput,
							} )
						}
						label={ __( 'Add Link for the Tile', 'aquila-theme' ) }
					/>
				</ToolbarGroup>
				<MediaControls
					imageID={ imageID }
					imageURL={ imageURL }
					onSelectMedia={ setMediaHandler }
					onResetMedia={ resetMediaHandler }
				/>
			</BlockControls>

			{ attributes.showURLInput && editMode && (
				<Popover
					position="bottom center"
					onClose={ () => setAttributes( { showURLInput: false } ) }
					anchor={ cardRef.current }
				>
					<LinkControl
						settings={ [] }
						value={ linkMeta }
						key={ `image-tile-link-${ clientId }` }
						onRemove={ () =>
							setAttributes( { linkMeta: {}, link: '' } )
						}
						onChange={ ( newLinkMeta ) =>
							setAttributes( {
								linkMeta: newLinkMeta,
								link: newLinkMeta?.url ?? '',
							} )
						}
					/>
				</Popover>
			) }

			<div { ...blockProps }>
				<MediaPreview
					url={ imageURL }
					placeholderTitle={ __( 'Image', 'aquila-theme' ) }
					onSelect={ setMediaHandler }
					wrapperClassName="image-tile__image-wrap"
					imgAlt={ imageAlt || __( 'Image tile image', 'aquila-theme' ) }
				/>
				<div className="image-tile__content" ref={ cardRef }>
					{ imageURL && <>
						{ editMode ? (
							<RichText
								tagName="p"
								value={ attributes.preHeading }
								onChange={ ( preHeading ) =>
									setAttributes( { preHeading } )
								}
								placeholder={ __( 'Pre Heading', 'aquila-theme' ) }
								className="image-tile__pre_heading has-tiny-font-size"
								allowedFormats={ [] }
							/>
						) : (
							<p className="image-tile__pre_heading has-tiny-font-size">
								{ attributes.preHeading }
							</p>
						) }
						<h3 className="image-tile__heading has-large-font-size">
							{ editMode ? (
								<RichText
									tagName="span"
									value={ attributes.heading }
									onChange={ ( heading ) =>
										setAttributes( { heading } )
									}
									placeholder={ __( 'Heading', 'aquila-theme' ) }
									className="image-tile__heading-text"
									allowedFormats={ [] }
								/>
							) : (
								<span className="image-tile__heading-text">
									{ attributes.heading }
								</span>
							) }
							{ cardLink && <ArrowRightSVG /> }
						</h3>
					</> }
				</div>
			</div>
		</>
	);
}
