/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { pullLeft, pullRight } from '@wordpress/icons';
import {
	useBlockProps,
	RichText,
	InnerBlocks,
	MediaReplaceFlow,
	BlockControls,
	BlockVerticalAlignmentControl,
} from '@wordpress/block-editor';
import { useState } from '@wordpress/element';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import {
	DEFAULT_TEMPLATE,
	ALLOWED_IMAGE_TYPE,
} from './constants';
import MediaSection from './media-section';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.setAttributes Block Attributes setter method.
 * @param {Object} props.attributes    Block attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	// State to manage notices
	const [ notices, setNotices ] = useState( null );

	// Destructure attributes
	const {
		overline,
		heading,
		imageID,
		imageURL,
		imageAlt,
		mediaPosition,
		verticalAlign,
	} = attributes;

	// Block props
	const blockProps = useBlockProps( {
		className: classnames(
			'media-text-narrow',
			'alignwide',
			`media-text-narrow--media-align-${ mediaPosition }`,
			`media-text-narrow--vertical-align-${ verticalAlign }`,
		),
	} );

	// Check if image is present
	const hasImage = Boolean( imageID ) && imageID > 0;

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

		// Reset notices
		setNotices( null );
	};

	// Reset media handler
	const resetMedia = () => {
		setAttributes( {
			imageID: 0,
			imageURL: '',
			imageAlt: '',
		} );
	};

	// Handle error function
	const handleError = ( error ) => {
		setNotices(
			<div className="notice notice-error is-dismissible">
				<p>{ String( error ) || __( 'Error uploading image.', 'one-novanta-theme' ) }</p>
			</div>,
		);
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<BlockVerticalAlignmentControl
						onChange={ ( newVerticalAlign ) =>
							setAttributes( { verticalAlign: newVerticalAlign } )
						}
						value={ verticalAlign }
					/>
				</ToolbarGroup>
				<ToolbarGroup>
					<ToolbarButton
						icon={ pullLeft }
						title={ __( 'Show media on left' ) }
						isActive={ mediaPosition === 'left' }
						onClick={ () =>
							setAttributes( { mediaPosition: 'left' } )
						}
					/>
					<ToolbarButton
						icon={ pullRight }
						title={ __( 'Show media on right' ) }
						isActive={ mediaPosition === 'right' }
						onClick={ () =>
							setAttributes( { mediaPosition: 'right' } )
						}
					/>
				</ToolbarGroup>
				<ToolbarGroup>
					<MediaReplaceFlow
						mediaId={ imageID }
						mediaURL={ imageURL }
						allowedTypes={ ALLOWED_IMAGE_TYPE }
						accept="image/*"
						name={ hasImage ? __( 'Replace image', 'one-novanta-theme' ) : __( 'Add image', 'one-novanta-theme' ) }
						onSelect={ onSelectMedia }
						onError={ handleError }
						notices={ notices }
						onReset={ resetMedia }
					/>
				</ToolbarGroup>
			</BlockControls>
			<div { ...blockProps }>
				<MediaSection
					hasImage={ hasImage }
					imageURL={ imageURL }
					imageAlt={ imageAlt }
					onSelectMedia={ onSelectMedia }
					notices={ notices }
					handleError={ handleError }
				/>
				<div className="media-text-narrow__content">
					<RichText
						tagName="p"
						className="media-text-narrow__overline has-small-font-size"
						value={ overline }
						onChange={ ( updatedOverline ) => setAttributes( { overline: updatedOverline } ) }
						placeholder={ __( 'Industry 01', 'one-novanta-theme' ) }
					/>
					<RichText
						tagName="p"
						className="media-text-narrow__custom-title has-heading-font-family has-medium-font-size"
						value={ heading }
						onChange={ ( updatedHeading ) => setAttributes( { heading: updatedHeading } ) }
						placeholder={ __( 'Automotive', 'one-novanta-theme' ) }
					/>
					<InnerBlocks
						template={ DEFAULT_TEMPLATE }
						templateLock={ false }
						directInsert
					/>
				</div>
			</div>
		</>
	);
}
