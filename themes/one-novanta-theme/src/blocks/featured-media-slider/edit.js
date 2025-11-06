/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Button, ToolbarGroup } from '@wordpress/components';
import { BlockControls, MediaPlaceholder, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';

/**
 * ArrowRightFullSVG JSX Component.
 */
const ArrowRightFullSVG = () => (
	<svg xmlns="http://www.w3.org/2000/svg" width="34" height="25" viewBox="0 0 34 25" fill="none">
		<path stroke="currentColor" d="M32.5 12.5H1.5M20.5 1L32.5 12.5L20.5 24" />
	</svg>
);

/**
 * Editor side of the block.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block Attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { content = [] } = attributes;

	const baseClassName = 'featured-media-slider';

	const blockProps = useBlockProps( {
		className: `${ baseClassName }__content`,
	} );

	const onSelectImages = ( selectedImages ) => {
		const updatedImages = selectedImages.map( ( img ) => ( {
			imageID: img.id,
			url: img.url,
			caption: img.caption || '',
		} ) );
		setAttributes( { content: updatedImages } );
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ onSelectImages }
							allowedTypes={ [ 'image' ] }
							multiple
							gallery
							value={ content.map( ( img ) => img.imageID ) }
							render={ ( { open } ) => (
								<Button variant="tertiary" onClick={ open }>
									{ content.length > 0 ? __( 'Edit Gallery', 'one-novanta-theme' ) : __( 'Upload / Select Images', 'one-novanta-theme' ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>
				</ToolbarGroup>
			</BlockControls>
			{ content.length === 0 ? <MediaPlaceholder
				icon="format-gallery"
				labels={ { title: __( 'Gallery', 'one-novanta-theme' ), instructions: __( 'Drag images, upload new ones or select files from your library.', 'one-novanta-theme' ) } }
				onSelect={ onSelectImages }
				accept="image/*"
				allowedTypes={ [ 'image' ] }
				multiple
			/>
				: <div { ...blockProps }>
					<rt-slider class={ `${ baseClassName }__slider` }>
						<rt-slider-track class={ `${ baseClassName }__track` }>
							<rt-slider-slides class={ `${ baseClassName }__slides` }>
								{
									content.map( ( value, idx ) => (
										<>
											<rt-slider-slide class={ `${ baseClassName }__slide` } key={ idx }>
												<img src={ value?.url ?? '' } alt={ value?.alt ?? __( 'Slider Image', 'one-novanta-theme' ) } />
												<p className={ `${ baseClassName }__caption` }>{ value?.caption ?? '' }</p>
											</rt-slider-slide>
										</>
									) )
								}
							</rt-slider-slides>
						</rt-slider-track>
						<div className={ `${ baseClassName }__navigation` }>
							<rt-slider-arrow class={ `${ baseClassName }-arrow ${ baseClassName }-arrow--previous` }>
								<button className={ `arrow-btn ${ baseClassName }-arrow-button` }>
									<ArrowRightFullSVG />
								</button>
							</rt-slider-arrow>
							<rt-slider-arrow class={ `${ baseClassName }-arrow ${ baseClassName }-arrow--next` }>
								<button className={ `arrow-btn ${ baseClassName }-arrow-button` }>
									<ArrowRightFullSVG />
								</button>
							</rt-slider-arrow>
						</div>
					</rt-slider>
				</div>
			}
		</>
	);
}
