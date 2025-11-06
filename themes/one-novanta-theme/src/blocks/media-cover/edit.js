/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	InspectorControls,
	MediaUploadCheck,
	MediaUpload,
	RichText,
	InnerBlocks,
	BlockControls,
} from '@wordpress/block-editor';
import {
	PanelBody,
	Button,
	SelectControl,
} from '@wordpress/components';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   props               Block properties.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Method to update block attributes.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { heading, description, imageURL, contentAlignment, contentWidth } = attributes;

	const ALLOWED_MEDIA_TYPES = [ 'image' ];

	const blockProps = useBlockProps( {
		className: `one-novanta-media-cover is-layout-constrained alignfull one-novanta-media-cover--content-align-${ contentAlignment } one-novanta-media-cover--content-width-${ contentWidth }`,
	} );

	return (
		<>
			<BlockControls group="other">
				<MediaUploadCheck>
					<MediaUpload
						onSelect={
							( media ) => {
								setAttributes( { imageID: media?.id ?? 0, imageURL: media?.url ?? '' } );
							}
						}
						allowedTypes={ ALLOWED_MEDIA_TYPES }
						value={ imageURL }
						render={ ( { open } ) => (
							<Button
								onClick={ open }
								className="media-upload">
								{ ! imageURL && (
									<>{ __( 'Add Media', 'one-novanta-theme' ) }</>
								) }
								{ imageURL && (
									<>{ __( 'Replace Media', 'one-novanta-theme' ) }</>
								) }
							</Button>
						) }
					/>
				</MediaUploadCheck>
			</BlockControls>

			<InspectorControls>
				<PanelBody title={ __( 'Media Cover Options', 'one-novanta-theme' ) }>
					<SelectControl
						label={ __( 'Content alignment', 'one-novanta-theme' ) }
						value={ contentAlignment }
						options={ [
							{ label: __( 'Left', 'one-novanta-theme' ), value: 'left' },
							{ label: __( 'Right', 'one-novanta-theme' ), value: 'right' },
						] }
						onChange={ ( value ) => setAttributes( { contentAlignment: value } ) }
					/>
					<SelectControl
						label={ __( 'Content width', 'one-novanta-theme' ) }
						value={ contentWidth }
						options={ [
							{ label: __( 'Wide', 'one-novanta-theme' ), value: 'wide' },
							{ label: __( 'Narrow', 'one-novanta-theme' ), value: 'narrow' },
						] }
						onChange={ ( value ) => setAttributes( { contentWidth: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<figure className="one-novanta-media-cover__image-wrap alignfull">
					{
						imageURL &&
						<img src={ imageURL } alt="" />
					}
				</figure>

				<div className="one-novanta-media-cover__content has-medium-font-size alignwide">
					<div className="one-novanta-media-cover__content-wrap">
						<RichText
							tagName="h3"
							className="one-novanta-media-cover__heading"
							placeholder={ __( 'Write Heading…', 'one-novanta-theme' ) }
							value={ heading }
							onChange={ ( value ) => setAttributes( { heading: value } ) }
							allowedFormats={ [] }
						/>

						<RichText
							tagName="p"
							className="one-novanta-media-cover__description"
							placeholder={ __( 'Write Description…', 'one-novanta-theme' ) }
							value={ description }
							onChange={ ( value ) => setAttributes( { description: value } ) }
							allowedFormats={ [] }
						/>

						<InnerBlocks
							allowedBlocks={ [] }
							template={ [
								[
									'core/buttons',
									{},
									[
										[
											'core/button',
											{
												text: __( 'Discover', 'one-novanta-theme' ),
											},
										],
									],
								],
							] }
						/>
					</div>
				</div>
			</div>
		</>
	);
}
