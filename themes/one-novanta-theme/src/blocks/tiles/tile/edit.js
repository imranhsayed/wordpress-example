/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useEffect } from '@wordpress/element';
import { link as linkIcon, linkOff } from '@wordpress/icons';
import { PanelBody, ToolbarGroup, ToolbarButton, Popover, ToggleControl } from '@wordpress/components';
// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- Reason WP internally uses LinkControl in paragraph and other blocks.
import { useBlockProps, InspectorControls, RichText, BlockControls, __experimentalLinkControl as LinkControl } from '@wordpress/block-editor';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import MediaControls from '../../../js/block-components/media-controls';
import MediaPreview from '../../../js/block-components/media-preview';

/**
 * Editor side of the block.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.setAttributes Block Attributes setter method.
 * @param {Object} props.attributes    Block attributes.
 * @param {Object} props.context       Block context.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes, context } ) {
	// Get all the attributes.
	const {
		imageID,
		imageURL,
		heading,
		subheading,
		hasDescription,
		description,
		url,
		showURLInput,
		backgroundColor,
	} = attributes;

	useEffect( () => {
		if ( context.backgroundColor ) {
			if ( 'background' === context.backgroundColor ) {
				setAttributes( { backgroundColor: 'secondary' } );
			}

			if ( 'secondary' === context.backgroundColor ) {
				setAttributes( { backgroundColor: 'background' } );
			}
		} else {
			setAttributes( { backgroundColor: 'secondary' } );
		}
	}, [ context, setAttributes ] );

	// Get the block props with custom class names.
	const blockProps = useBlockProps(
		{
			className: classnames(
				'tile-editor',
				{ [ `has-${ backgroundColor }-background-color` ]: backgroundColor },
				hasDescription && 'tile-editor--has-description',
			),
		},
	);

	// Start editing the tile link.
	const startEditing = () => {
		setAttributes( { showURLInput: true } );
	};

	// Unlink the tile.
	const unlinkTile = () => {
		setAttributes( { url: '' } );
		setAttributes( { showURLInput: false } );
	};

	// Set media handler
	const onSelectMedia = ( media ) => {
		// If no media is selected, return early
		if ( ! media || ! media.id ) {
			return;
		}

		// Pick the larege media URL if available, otherwise use the default URL
		const mediaURL = media.sizes?.large?.url || media.url;

		// Set imageID, imageURL, and imageAlt attributes
		setAttributes( {
			imageID: media.id,
			imageURL: mediaURL,
			imageAlt: media.alt,
		} );
	};

	// Reset media handler
	const resetMedia = () => {
		setAttributes( {
			imageID: 0,
			imageURL: '',
			imageAlt: '',
		} );
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					{ ! url ? (
						<ToolbarButton
							icon={ linkIcon }
							label={ __( 'Add tile link', 'one-novanta-theme' ) }
							onClick={ startEditing }
						/>
					) : (
						<ToolbarButton
							icon={ linkOff }
							label={ __( 'Remove tile link', 'one-novanta-theme' ) }
							onClick={ unlinkTile }
							isActive={ true }
						/>
					) }
				</ToolbarGroup>
				<MediaControls
					imageID={ imageID }
					imageURL={ imageURL }
					onSelectMedia={ onSelectMedia }
					onResetMedia={ resetMedia }
				/>

			</BlockControls>
			<InspectorControls>
				<PanelBody title={ __( 'Tile Settings', 'one-novanta-theme' ) }>
					<ToggleControl
						label={ __( 'Show Description', 'one-novanta-theme' ) }
						checked={ hasDescription }
						onChange={ () =>
							setAttributes( { hasDescription: ! hasDescription } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				{ showURLInput && (
					<Popover position="top center" onClose={ () => setAttributes( { showURLInput: false } ) } >
						<LinkControl
							value={ {
								url,
							} }
							onChange={ ( selectedLink ) => setAttributes( { url: selectedLink.url } ) }
							onRemove={ unlinkTile }
						/>
					</Popover>
				) }
				<MediaPreview
					url={ imageURL }
					onSelect={ onSelectMedia }
					wrapperClassName="tile-editor__figure"
					imgClassName="tile-editor__image"
					imgAlt={ __( 'Tile Image', 'one-novanta-theme' ) }
					placeholderTitle={ __( 'Image', 'one-novanta-theme' ) }
				/>
				<div className="tile-editor__content-wrapper">
					<div className="tile-editor__content">
						{ ! hasDescription &&
							<RichText
								tagName="p"
								className="tile-editor__subheading has-heading-font-family has-tiny-font-size"
								value={ subheading }
								onChange={ ( updatedSubheading ) => setAttributes( { subheading: updatedSubheading } ) }
								placeholder={ __( 'Subheading', 'one-novanta-theme' ) }
								allowedFormats={ [] }
							/>
						}
						<RichText
							tagName="h3"
							className="tile-editor__heading"
							value={ heading }
							onChange={ ( updatedHeading ) => setAttributes( { heading: updatedHeading } ) }
							placeholder={ __( 'Heading', 'one-novanta-theme' ) }
							allowedFormats={ [] }
						/>
						{ hasDescription &&
							<RichText
								tagName="p"
								className="tile-editor__description"
								value={ description }
								onChange={ ( updatedDescription ) => setAttributes( { description: updatedDescription } ) }
								placeholder={ __( 'Description', 'one-novanta-theme' ) }
								allowedFormats={ [] }
							/>
						}
					</div>
					{ url &&
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="30" fill="none" viewBox="0 0 16 30"><path stroke="currentColor" d="M.86.857 15.001 15 .858 29.142" /></svg>
					}
				</div>
			</div>
		</>
	);
}
