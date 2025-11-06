/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	MediaUploadCheck,
	MediaUpload,
	RichText,
	InnerBlocks,
	BlockControls,
} from '@wordpress/block-editor';
import {
	Button,
	ToolbarDropdownMenu,
} from '@wordpress/components';
import { justifyLeft, justifyRight } from '@wordpress/icons';

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
	const { heading, description, imageURL, contentAlignment } = attributes;

	const ALLOWED_MEDIA_TYPES = [ 'image' ];

	const blockProps = useBlockProps( {
		className: `one-novanta-media-text-cover alignwide one-novanta-media-text-cover--content-align-${ contentAlignment }`,
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

				<ToolbarDropdownMenu
					icon={ 'left' === contentAlignment ? justifyLeft : justifyRight }
					label={ __( 'Content Width', 'one-novanta-theme' ) }
					controls={ [
						{
							title: __( 'Left', 'one-novanta-theme' ),
							icon: justifyLeft,
							isActive: 'left' === contentAlignment,
							onClick: () => setAttributes( { contentAlignment: 'left' } ),
						},
						{
							title: __( 'Right', 'one-novanta-theme' ),
							icon: justifyRight,
							isActive: 'right' === contentAlignment,
							onClick: () => setAttributes( { contentAlignment: 'right' } ),
						},
					] }
				/>
			</BlockControls>

			<div { ...blockProps }>
				<figure className="one-novanta-media-text-cover__image-wrap">
					{
						imageURL &&
						<img src={ imageURL } alt="" />
					}
				</figure>

				<div className="one-novanta-media-text-cover__content has-medium-font-size">
					<RichText
						tagName="h2"
						className="one-novanta-media-text-cover__heading has-xx-large-font-size"
						placeholder={ __( 'Write Heading…', 'one-novanta-theme' ) }
						value={ heading }
						onChange={ ( value ) => setAttributes( { heading: value } ) }
						allowedFormats={ [] }
					/>

					<RichText
						tagName="p"
						className="one-novanta-media-text-cover__description"
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
											text: __( 'Contact us', 'one-novanta-theme' ),
										},
									],
								],
							],
						] }
					/>
				</div>
			</div>
		</>
	);
}
