/**
 * WordPress dependencies
 */
import { createBlock, cloneBlock } from '@wordpress/blocks';
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';
import { useSelect, useDispatch } from '@wordpress/data';
import { useCallback, useEffect } from '@wordpress/element';

/**
 * External dependencies
 */
import classnames from 'classnames';

// Recursively search for the first block that matches a predicate
const findBlockDeep = ( blocks, predicate ) => {
	for ( const block of blocks ) {
		if ( predicate( block ) ) {
			return block;
		}
		if ( block.innerBlocks?.length ) {
			const found = findBlockDeep( block.innerBlocks, predicate );
			if ( found ) {
				return found;
			}
		}
	}
	return null;
};

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} props            Block properties.
 * @param {string} props.className  Block class name.
 * @param {Object} props.attributes Block attributes.
 *
 * @param {string} props.clientId
 * @param {Object} props.context
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( { attributes, className, clientId, context } ) {
	const { showTitle = true, showDescription = true, headingLayout = 'stack', showButtons = false, template = '' } = context;

	const { templateLock } = attributes;

	// Block props.
	const blockProps = useBlockProps( {
		className: classnames(
			'one-novanta-section__header alignwide',
			className,
		),
	} );

	const { getBlocks } = useSelect(
		( select ) => ( {
			getBlocks: select( 'core/block-editor' ).getBlocks,
		} ),
		[],
	);
	const { replaceInnerBlocks } = useDispatch( 'core/block-editor' );

	/* -----------------------------------------
       Build new block structure, cloning existing
       content when available.
    ------------------------------------------*/
	const buildStructure = useCallback( () => {
		const existing = getBlocks( clientId );

		// Helpers to pull existing blocks
		const h2 = findBlockDeep(
			existing,
			( b ) => b.name === 'core/heading' && b.attributes.level === 2,
		);
		const h3 = findBlockDeep(
			existing,
			( b ) => b.name === 'core/heading' && b.attributes.level === 3,
		);
		const paragraph = findBlockDeep(
			existing,
			( b ) => b.name === 'core/paragraph',
		);
		const buttons = findBlockDeep(
			existing,
			( b ) => b.name === 'core/buttons',
		);

		// Factory helpers
		const blockOrNew = ( existingBlock, name, attrs, inner = [] ) =>
			existingBlock
				? cloneBlock( existingBlock, {
					...existingBlock.attributes,
					...attrs,
				} )
				: createBlock( name, attrs, inner );

		const topBlocks = [];

		// Top‑level H2
		if ( showTitle ) {
			topBlocks.push(
				blockOrNew( h2, 'core/heading', {
					level: 2,
					placeholder: 'Section title…',
					className: classnames(
						'one-novanta-section__title',
					),
					fontSize: 'xx-large',
				} ),
			);
		}

		if ( headingLayout === 'stack' ) {
			// Description
			if ( showDescription ) {
				topBlocks.push(
					blockOrNew( paragraph, 'core/paragraph', {
						placeholder: 'Add description…',
						className: classnames(
							'one-novanta-section__description',
							'has-medium-font-size',
							'has-heading-font-family',
						),
						fontFamily: 'heading',
						fontSize: 'medium',
					} ),
				);
			}
			// Buttons (horizontal)
			if ( showButtons ) {
				topBlocks.push(
					blockOrNew(
						buttons,
						'core/buttons',
						{
							className: 'one-novanta-section__buttons',
							layout: { type: 'flex', orientation: 'horizontal' },
						},
						[
							createBlock( 'core/button', {
								className: 'is-style-outline',
								placeholder: 'Button 1',
							} ),
							createBlock( 'core/button', {
								className: 'is-style-fill',
								placeholder: 'Button 2',
							} ),
						],
					),
				);
			}
		}

		if ( headingLayout === 'columns' ) {
			const firstColInner = [];

			if ( showTitle ) {
				firstColInner.push(
					blockOrNew( h3, 'core/heading', {
						level: 3,
						placeholder: 'Section sub‑heading…',
						className: classnames(
							'one-novanta-section__subheading',
						),
					} ),
				);
			}

			if ( showDescription ) {
				firstColInner.push(
					blockOrNew( paragraph, 'core/paragraph', {
						className: classnames(
							'one-novanta-section__description',
						),
						placeholder: 'Add description…',
					} ),
				);
			}

			const columnsInner = [
				createBlock(
					'core/group',
					{
						layout: {
							type: 'flex',
							orientation: 'vertical',
						},
						className: 'one-novanta-section__first-column',
					},
					firstColInner,
				),
			];

			// Second column: buttons (vertical)
			if ( showButtons ) {
				const btnBlock = blockOrNew(
					buttons,
					'core/buttons',
					{
						className: 'one-novanta-section__buttons',
						layout: { type: 'flex', orientation: 'vertical' },
					},
					[
						createBlock( 'core/button', {
							className: 'is-style-outline',
							placeholder: 'Button 1',
						} ),
						createBlock( 'core/button', {
							className: 'is-style-fill',
							placeholder: 'Button 2',
						} ),
					] );

				const wrapBtnBlock = createBlock(
					'core/group',
					{
						templateLock: false,
						layout: {
							type: 'flex',
							orientation: 'vertical',
						},
						className: 'one-novanta-section__buttons-wrap',
					},
					[ btnBlock ],
				);
				columnsInner.push( wrapBtnBlock );
			}

			topBlocks.push(
				createBlock(
					'core/group',
					{
						layout: {
							type: 'flex',
							justifyContent: 'space-between',
							verticalAlignment: 'top',
						},
						className: 'one-novanta-section__columns',
						templateLock: 'all',
					},
					columnsInner,
				),
			);
		}

		return topBlocks;
	}, [ getBlocks, clientId, showTitle, headingLayout, template, showDescription, showButtons ] );

	/* Template sync whenever toggles/layout change */
	useEffect( () => {
		replaceInnerBlocks( clientId, buildStructure(), false );
	}, [
		showTitle,
		showDescription,
		headingLayout,
		showButtons,
		replaceInnerBlocks,
		clientId,
		buildStructure,
	] );

	// Inner blocks props.
	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		templateLock,
		renderAppender: false,
	} );

	return <div { ...innerBlocksProps } />;
}
