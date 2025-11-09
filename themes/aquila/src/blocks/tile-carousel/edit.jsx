/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useEffect } from '@wordpress/element';
import { createBlock } from '@wordpress/blocks';
import { useSelect, dispatch } from '@wordpress/data';
import { BaseControl, Button, PanelBody } from '@wordpress/components';
import { InnerBlocks, InspectorControls, useBlockProps, store as blockEditorStore } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import previousSvg from '../../svg/arrow-right.svg';

/**
 * Editor side of the block.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block Attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 * @param {Object} props.clientId      A unique identifier assigned to each block instance.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes, clientId } ) {
	/**
	 * True  -> Editors can edit block.
	 * False -> Editors cannot edit block.
	 */
	const { editMode, totalSlides } = attributes;

	// Get the inner blocks to track the number of slides
	const innerBlocks = useSelect(
		( select ) => select( blockEditorStore ).getBlocks( clientId ),
		[ clientId ],
	);

	// Update totalSlides attribute when innerBlocks changes
	useEffect( () => {
		if ( innerBlocks && innerBlocks.length !== totalSlides ) {
			setAttributes( { totalSlides: innerBlocks.length } );
		}
	}, [ innerBlocks, totalSlides, setAttributes ] );

	const blockProps = useBlockProps( {
		className: 'tile-carousel__content',
	} );

	// Function to add a new slide block dynamically
	const addSlide = () => {
		dispatch( blockEditorStore ).insertBlocks(
			createBlock( 'aquila/image-tile' ),
			undefined,
			clientId,
			false,
		);
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Carousel Settings', 'aquila-theme' ) } className="tile-carousel-editor__settings-panel">
					<BaseControl __nextHasNoMarginBottom label={ __( 'Slides Management', 'aquila-theme' ) } id="slides-management">
						<Button
							variant="primary"
							onClick={ addSlide }
							style={ { marginBottom: '12px', display: 'block' } }
							disabled={ ! editMode }
						>
							{ __( 'Add Carousel Slide', 'aquila-theme' ) }
						</Button>
						<p>{ __( 'Total Slides:', 'aquila-theme' ) } { totalSlides || 0 }</p>
					</BaseControl>

					<BaseControl __nextHasNoMarginBottom label={ __( 'Toggle Edit Mode', 'aquila-theme' ) } id="edit-mode-toggle">
						<Button
							variant="secondary"
							onClick={ () => setAttributes( { editMode: ! editMode } ) }
							style={ { display: 'block' } }
						>
							{ editMode
								? __( 'Disable Edit Mode', 'aquila-theme' )
								: __( 'Enable Edit Mode', 'aquila-theme' ) }
						</Button>
						{ ! editMode && <BaseControl label={ __( 'Please enable the edit mode, to continue editing the card.', 'aquila-theme' ) } __nextHasNoMarginBottom id="slides-management" className="tile-carousel-editor__settings-panel__media--info" /> }
					</BaseControl>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="tile-carousel__content">
					<div className="tile-carousel__slider">
						<div className="tile-carousel-editor__track">
							<div className={ `tile-carousel-editor__slides ${ editMode ? 'tile-carousel-editor__slides--edit' : '' }` }>
								<InnerBlocks
									allowedBlocks={ [ 'aquila/image-tile' ] }
									template={ [
										[ 'aquila/image-tile' ],
									] }
									orientation="horizontal"
									templateLock={ false }
								/>
							</div>
						</div>
						{
							! editMode && (
								<div className="tile-carousel-editor__navigation">
									<div className="tile-carousel-editor__navigation-arrow tile-carousel-editor__navigation-arrow--previous">
										<button className="arrow-btn tile-carousel-editor__navigation-arrow-button">
											<img src={ previousSvg } alt={ __( 'Previous', 'aquila-theme' ) } />
										</button>
									</div>
									<div className="tile-carousel-editor__navigation-arrow tile-carousel-editor__navigation-arrow--next">
										<button className="arrow-btn tile-carousel-editor__navigation-arrow-button">
											<img src={ previousSvg } alt={ __( 'Next', 'aquila-theme' ) } />
										</button>
									</div>
								</div>
							)
						}
					</div>
				</div>
			</div>
		</>
	);
}
