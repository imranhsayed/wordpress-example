/**
 * WordPress dependencies
 */
import { InspectorControls, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { BaseControl, Button, PanelBody, RangeControl } from '@wordpress/components';
import { dispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Editor side of the block.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 * @param {Object} props.clientId      A unique identifier assigned to each block instance.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes, clientId } ) {
	// Get the block props with custom class names.
	const blockProps = useBlockProps(
		{
			className: classnames(
				'tiles-editor',
				'grid',
				attributes.numberOfColumns && `grid--cols-${ attributes.numberOfColumns }`,
			),
		},
	);
	// Set the block props for inner blocks.
	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{
			allowedBlocks: [ 'one-novanta/tile' ],
			template: [ [ 'one-novanta/tile' ] ],
			templateLock: false,
			orientation: 'horizontal',
		},
	);

	// Add tile new tile.
	const addTile = () => {
		dispatch( 'core/block-editor' ).insertBlocks(
			wp.blocks.createBlock( 'one-novanta/tile' ),
			undefined,
			clientId,
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
					<RangeControl
						label={ __( 'Number of columns', 'one-novanta-theme' ) }
						min={ 2 }
						max={ 4 }
						value={ attributes.numberOfColumns }
						onChange={ ( numberOfColumns ) => setAttributes( { numberOfColumns } ) }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...innerBlocksProps } />
		</>
	);
}
