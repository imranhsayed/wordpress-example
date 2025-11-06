/**
 * WordPress dependencies
 */
import { InnerBlocks, InspectorControls, useBlockProps, store as blockEditorStore } from '@wordpress/block-editor';
import { BaseControl, Button, PanelBody } from '@wordpress/components';
import { useDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { createBlock } from '@wordpress/blocks';

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} props          Block Props.
 *
 * @param {string} props.clientId
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( { clientId } ) {
	// Get the block props with custom class names.
	const blockProps = useBlockProps( {
		className: 'image-text-cards-editor__content',
	} );

	const { insertBlock } = useDispatch( blockEditorStore );

	const addTile = () => {
		insertBlock(
			createBlock( 'one-novanta/image-tile' ),
			undefined,
			clientId,
			false,
		);
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Tiles Settings', 'one-novanta-theme' ) }>
					<BaseControl __nextHasNoMarginBottom label={ __( 'Add new tile', 'one-novanta-theme' ) } id="add-new-tile" >
						<Button variant="primary" onClick={ addTile }>
							{ __( 'Add New Tile', 'one-novanta-theme' ) }
						</Button>
					</BaseControl>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps } >
				<div className="grid">
					<InnerBlocks
						templateLock={ false }
						allowedBlocks={ [ 'one-novanta/image-tile' ] }
						template={ [
							[ 'one-novanta/image-tile' ],
						] }
						orientation="horizontal"
					/>
				</div>
			</div>
		</>
	);
}
