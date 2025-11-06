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
				'cards',
				'grid',
				attributes.numberOfColumns && `grid--cols-${ attributes.numberOfColumns }`,
			),
		},
	);

	// Set the block props for inner blocks.
	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{
			allowedBlocks: [ 'one-novanta/card' ],
			template: [
				[
					'one-novanta/card',
					{
						heading: __( 'Card Title', 'one-novanta-theme' ),
						content: __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'one-novanta-theme' ),
					},
				],
			],
			orientation: 'horizontal',
			templateLock: false,
		},
	);

	// Add new card.
	const addNewCard = () => {
		dispatch( 'core/block-editor' ).insertBlocks(
			wp.blocks.createBlock( 'one-novanta/card' ),
			undefined,
			clientId,
		);
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Cards Settings', 'one-novanta-theme' ) }>
					<BaseControl __nextHasNoMarginBottom label={ __( 'Add new card', 'one-novanta-theme' ) } id="add-new-card" >
						<Button variant="primary" onClick={ addNewCard }>
							{ __( 'Add New Card', 'one-novanta-theme' ) }
						</Button>
					</BaseControl>
					<RangeControl
						label={ __( 'Number of Columns', 'one-novanta-theme' ) }
						min={ 1 }
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
