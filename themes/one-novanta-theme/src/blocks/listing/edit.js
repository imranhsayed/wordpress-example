/**
 * WordPress dependencies
 */
import { InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { dispatch, useSelect } from '@wordpress/data';
import { Button, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { store as viewportStore } from '@wordpress/viewport';

/**
 * Editor side of the block.
 *
 * @param {Object} props          Block Props.
 * @param {Object} props.clientId A unique identifier assigned to each block instance.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { clientId } ) {
	const isSmall = useSelect(
		( select ) => select( viewportStore ).isViewportMatch( '< large' ),
		[],
	);
	const orientation = isSmall ? 'vertical' : 'horizontal';

	// Block props.
	const blockProps = useBlockProps( {
		className: 'alignwide',
	} );

	// Inner blocks props.
	const innerBlockProps = useInnerBlocksProps(
		{
			className: 'grid grid--cols-2 alignwide',
		},
		{
			template: [
				[ 'one-novanta/listing-item' ],
			],
			allowedBlocks: [ 'one-novanta/listing-item' ],
			templateLock: false,
			orientation,
		},
	);

	const addListingItem = () => {
		dispatch( 'core/block-editor' ).insertBlocks(
			wp.blocks.createBlock( 'one-novanta/listing-item' ),
			undefined,
			clientId,
		);
	};

	return <>
		<InspectorControls>
			<PanelBody
				title={ __( 'Listing Block Options', 'one-novanta-theme' ) }
				initialOpen={ false }
			>
				<Button
					variant="primary"
					onClick={ addListingItem }
				>
					{ __( 'Add listing item', 'one-novanta-theme' ) }
				</Button>
			</PanelBody>
		</InspectorControls>
		<div { ...blockProps }>
			<div { ...innerBlockProps } />
		</div>
	</>;
}
