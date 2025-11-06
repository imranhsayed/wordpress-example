/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import {
	useBlockProps,
	useInnerBlocksProps,
	RichText,
	InnerBlocks,
	InspectorControls,
	store as blockEditorStore,
} from '@wordpress/block-editor';
import { createBlock } from '@wordpress/blocks';
import {
	PanelBody,
	SelectControl,
	Button,
	TextControl,
	Flex,
	FlexItem,
	FlexBlock,
	Icon,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalDivider as Divider,
} from '@wordpress/components';
import { useEffect } from '@wordpress/element';
import {
	dragHandle,
	plus,
	trash,
	chevronUp,
	chevronDown,
} from '@wordpress/icons';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Edit component.
 *
 * @param {Object}   props               Component props.
 * @param {string}   props.className     Block class name.
 * @param {string}   props.clientId      Block client ID.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Block attributes setter.
 */
export default function Edit( {
	className,
	clientId,
	attributes,
	setAttributes,
} ) {
	// Block props.
	const blockProps = useBlockProps( {
		className: classnames( className, 'tabs', 'typography-spacing' ),
	} );

	// Inner blocks props.
	const innerBlockProps = useInnerBlocksProps(
		{
			className: 'novanta-tabs-nav__content',
		},
		{
			template: [
				[ 'one-novanta/tab-item', { title: __( 'Tab 1', 'one-novanta-theme' ) } ],
				[ 'one-novanta/tab-item', { title: __( 'Tab 2', 'one-novanta-theme' ) } ],
				[ 'one-novanta/tab-item', { title: __( 'Tab 3', 'one-novanta-theme' ) } ],
			],
			renderAppender: () => null,
			orientation: 'horizontal',
			templateLock: false,
		},
	);

	// Get the inner blocks.
	const innerBlocks = useSelect(
		( select ) => select( blockEditorStore ).getBlocks( clientId ),
		[ clientId ],
	);

	// Get dispatcher.
	const { updateBlockAttributes, moveBlocksDown, moveBlocksUp, insertBlock, removeBlock } = useDispatch( blockEditorStore );

	// Set the default tab.
	useEffect( () => {
		// Set the default tab index.
		if ( ! attributes.defaultTabIndex ) {
			setAttributes( { defaultTabIndex: 1 } );
		}

		// Set the active tab client ID.
		if ( ! attributes.activeTabClientId ) {
			setAttributes( {
				activeTabClientId:
					innerBlocks?.[ attributes.defaultTabIndex - 1 ]?.clientId,
			} );
		}
	}, [ attributes.activeTabClientId, attributes.defaultTabIndex, innerBlocks, setAttributes ] );

	// Return the block's markup.
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Tabs Options', 'one-novanta-theme' ) }>
					<SelectControl
						label={ __( 'Active Tab', 'one-novanta-theme' ) }
						value={ attributes.defaultTabIndex }
						onChange={ ( value ) =>
							setAttributes( { defaultTabIndex: parseInt( value ) } )
						}
						options={ innerBlocks.map( ( innerBlock, index ) => ( {
							label:
								innerBlock.attributes.title?.toUpperCase() ||
								`No title ( tab ${ index + 1 } )`,
							value: ( index + 1 ).toString(),
						} ) ) }
					/>
					<p>
						{ __(
							'Maximum of 10 tabs are allowed.',
							'one-novanta-theme',
						) }
					</p>
				</PanelBody>

				<PanelBody title={ __( 'Tab Management', 'one-novanta-theme' ) } initialOpen={ true }>
					<div className="novanta-tabs-manager">
						{ innerBlocks.map( ( innerBlock, index ) => (
							<div key={ innerBlock.clientId } className="novanta-tabs-manager__item">
								<Flex align="center" className="novanta-tabs-manager__item-container">
									<FlexItem>
										<Icon icon={ dragHandle } />
									</FlexItem>
									<FlexBlock>
										<TextControl
											value={ innerBlock.attributes.title || '' }
											onChange={ ( value ) => updateBlockAttributes( innerBlock.clientId, {
												title: value,
											} ) }
											placeholder={ __( 'Tab title', 'one-novanta-theme' ) }
										/>
									</FlexBlock>
									<FlexItem>
										<Button
											icon={ chevronUp }
											size="small"
											disabled={ index === 0 }
											onClick={ () => {
												moveBlocksUp( [ innerBlock.clientId ], clientId );
											} }
											label={ __( 'Move up', 'one-novanta-theme' ) }
										/>
									</FlexItem>
									<FlexItem>
										<Button
											icon={ chevronDown }
											size="small"
											disabled={ index === innerBlocks.length - 1 }
											onClick={ () => {
												moveBlocksDown( [ innerBlock.clientId ], clientId );
											} }
											label={ __( 'Move down', 'one-novanta-theme' ) }
										/>
									</FlexItem>
									<FlexItem>
										<Button
											icon={ trash }
											isDestructive
											size="small"
											disabled={ innerBlocks.length <= 1 }
											onClick={ () => {
												removeBlock( innerBlock.clientId );

												// Shift focus previous block if it exists.
												const previousBlockIndex = index - 1;
												if ( previousBlockIndex >= 0 ) {
													const previousBlock = innerBlocks[ previousBlockIndex ];
													setAttributes( {
														activeTabClientId: previousBlock.clientId,
													} );
												}
											} }
											label={ __( 'Remove tab', 'one-novanta-theme' ) }
										/>
									</FlexItem>
								</Flex>
								{ index < innerBlocks.length - 1 && <Divider /> }
							</div>
						) ) }

						{ innerBlocks.length < 10 && (
							<Flex align="center" className="novanta-tabs-manager__item-add">
								<FlexItem>
									<Button
										icon={ plus }
										variant="secondary"
										className="novanta-tabs-manager__add-button"
										onClick={ () => {
											const newTabBlock = createBlock( 'one-novanta/tab-item', {
												title: `Tab ${ innerBlocks.length + 1 }`,
											} );
											insertBlock( newTabBlock, innerBlocks.length, clientId, false );
										} }
									>
										{ __( 'Add Tab', 'one-novanta-theme' ) }
									</Button>
								</FlexItem>
							</Flex>
						) }
					</div>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<nav className="novanta-tabs-nav">
					{ innerBlocks.map( ( innerBlock ) => (
						<button
							key={ innerBlock.clientId }
							className={ classnames( 'novanta-tabs-nav__item', {
								'novanta-tabs-nav__item--active':
									innerBlock.clientId === attributes.activeTabClientId,
							} ) }
							onClick={ () =>
								setAttributes( { activeTabClientId: innerBlock.clientId } )
							}
						>
							<span className="novanta-tabs-nav__link">
								<RichText
									tagName="span"
									className="novanta-tabs-nav__title"
									placeholder={ __( 'Add title…', 'one-novanta-theme' ) }
									value={ innerBlock.attributes?.title || '' }
									allowedFormats={ [] }
									onChange={ ( value ) =>
										updateBlockAttributes( innerBlock.clientId, {
											title: value,
										} )
									}
								/>
							</span>
						</button>
					) ) }
					{ innerBlocks.length < 10 && <InnerBlocks.ButtonBlockAppender /> }
				</nav>
				<div { ...innerBlockProps } />
			</div>
		</>
	);
}
