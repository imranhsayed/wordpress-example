/**
 * WordPress dependencies
 */
import {
	useBlockProps,
	useInnerBlocksProps,
	InspectorControls,
	store as blockEditorStore,
} from '@wordpress/block-editor';
import { createBlock, store as blocksStore } from '@wordpress/blocks';
import { useEffect, useState } from '@wordpress/element';
import {
	PanelBody,
	ToggleControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalToggleGroupControl as ToggleGroupControl,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalToggleGroupControlOption as ToggleGroupControlOption,
} from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';

/**
 * External dependencies
 */
import classnames from 'classnames';

const TEMPLATE = [
	[ 'one-novanta/section-heading' ],
	[ 'one-novanta/section-content' ],
];

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   props               Block properties.
 * @param {string}   props.className     Block class name.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Method to update block attributes.
 *
 * @param {string}   props.clientId
 * @param {string}   props.name
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( {
	attributes,
	setAttributes,
	className,
	name,
	clientId,
} ) {
	const [ innerBlockTemplate, setInnerBlockTemplate ] = useState( TEMPLATE );

	// Destructure attributes.
	const { showTitle, showDescription, headingLayout, showButtons, templateLock } =
		attributes;

	// Get the block editor store.
	const { getBlock, getActiveBlockVariation } = useSelect( ( select ) => {
		return {
			getBlock: select( blockEditorStore ).getBlock,
			getActiveBlockVariation: select( blocksStore ).getActiveBlockVariation,
		};
	}, [] );

	const { insertBlock, replaceInnerBlocks } = useDispatch( blockEditorStore );

	// If it is a variation, set the inner template.
	useEffect( () => {
		if ( attributes.template !== '' ) {
			// Dynamically apply the variation's innerBlocks.
			const variation = getActiveBlockVariation(
				name, attributes );

			if ( variation && variation.innerBlocks ) {
				setInnerBlockTemplate( variation.innerBlocks );
			}
		}
	}, [ attributes, getActiveBlockVariation, name ] );

	// Effect to update inner blocks when showTitle, showDescription, or showButtons change
	useEffect( () => {
		// Check if any of the heading-related attributes are true
		const shouldHaveHeading = showTitle || showDescription || showButtons;

		// Get the current block
		const block = getBlock( clientId );

		if ( block && block.innerBlocks ) {
			let hasHeadingBlock = false;
			let contentBlock = null;
			let contentBlockIndex = -1;

			// Check for existing blocks
			block.innerBlocks.forEach( ( innerBlock, index ) => {
				if ( innerBlock.name === 'one-novanta/section-heading' ) {
					hasHeadingBlock = true;
				} else if ( innerBlock.name === 'one-novanta/section-content' ) {
					contentBlock = innerBlock;
					contentBlockIndex = index;
				}
			} );

			// Case 1: Need heading but don't have it
			if ( shouldHaveHeading && ! hasHeadingBlock ) {
				if ( contentBlock ) {
					// Content block exists, insert heading before it
					const headingBlock = createBlock( 'one-novanta/section-heading' );
					insertBlock( headingBlock, contentBlockIndex, clientId, false );
				} else {
					// Content block doesn't exist, create both blocks
					const newBlocks = [
						createBlock( 'one-novanta/section-heading' ),
						createBlock( 'one-novanta/section-content' ),
					];
					replaceInnerBlocks( clientId, newBlocks, false );
				}
			} else if ( ! shouldHaveHeading && hasHeadingBlock ) {
				// Case 2: Don't need heading but have it
				// Remove only the heading block, preserve content
				const newInnerBlocks = block.innerBlocks.filter(
					( innerBlock ) => innerBlock.name !== 'one-novanta/section-heading',
				);
				replaceInnerBlocks( clientId, newInnerBlocks, false );
			} else if ( block.innerBlocks.length === 0 ) {
				// Case 3: Empty block, need to initialize it
				const newBlocks = [];
				if ( shouldHaveHeading ) {
					newBlocks.push( createBlock( 'one-novanta/section-heading' ) );
				}
				newBlocks.push( createBlock( 'one-novanta/section-content' ) );
				replaceInnerBlocks( clientId, newBlocks, false );
			}
		}
	}, [ showTitle, showDescription, showButtons, headingLayout, clientId, getBlock, insertBlock, replaceInnerBlocks ] );

	// Block props.
	const blockProps = useBlockProps( {
		className: classnames( 'one-novanta-section alignfull', className ),
	} );

	// Inner blocks props.
	const innerBlocksProps = useInnerBlocksProps(
		blockProps,
		{
			templateLock,
			renderAppender: () => null,
			template: innerBlockTemplate,
		},
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title="Section Settings" initialOpen>
					<ToggleControl
						label="Show Title"
						checked={ showTitle }
						onChange={ ( v ) => setAttributes( { showTitle: v } ) }
					/>
					<ToggleControl
						label="Show Description"
						checked={ showDescription }
						onChange={ ( v ) => setAttributes( { showDescription: v } ) }
					/>
					<ToggleControl
						label="Show Buttons"
						checked={ showButtons }
						onChange={ ( v ) => setAttributes( { showButtons: v } ) }
					/>
					{
						showButtons && (
							<ToggleGroupControl
								__next40pxDefaultSize
								__nextHasNoMarginBottom
								isBlock
								label="Heading Layout"
								value={ headingLayout }
								onChange={ ( v ) => setAttributes( { headingLayout: v } ) }
							>
								<ToggleGroupControlOption
									value="columns"
									label="Columns"
								/>
								<ToggleGroupControlOption value="stack" label="Stack" />
							</ToggleGroupControl>
						)
					}
				</PanelBody>
			</InspectorControls>
			<div { ...innerBlocksProps } />
		</>
	);
}
