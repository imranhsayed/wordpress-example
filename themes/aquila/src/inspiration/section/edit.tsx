/**
 * WordPress dependencies.
 */
import { __ } from '@wordpress/i18n';
import {
	useBlockProps,
	useInnerBlocksProps,
	InspectorControls,
	RichText,
} from '@wordpress/block-editor';
import {
	PanelBody,
	ToggleControl,
	SelectControl,
} from '@wordpress/components';

/**
 * Internal dependencies.
 */
import Section from '../../components/section';
import LinkButton from '../../block-components/LinkButton';

/**
 * External dependencies.
 */
import classnames from 'classnames';
const { gumponents } = window;

/**
 * External components.
 */
const {
	ColorPaletteControl,
} = gumponents.components;

// Background colors.
export const colors: { [key: string]: string }[] = [
	{ name: __( 'Black', 'lb' ), color: '#232933', slug: 'black' },
	{ name: __( 'Gray', 'lb' ), color: '#F5F7FB', slug: 'gray' },
];

/**
 * Edit Component.
 *
 * @param {Object}   props               Component properties.
 * @param {string}   props.className     Class name.
 * @param {Array}    props.attributes    Block attributes.
 * @param {Function} props.setAttributes Set block attributes.
 */
export default function Edit( { className, attributes, setAttributes }: BlockEditAttributes ) {
	// Block props.
	const blockProps = useBlockProps( { className: classnames( 'section', className ) } );
	const innerBlocksProps = useInnerBlocksProps( { className: 'section__content' } );

	// Return block.
	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Section Options', 'lb' ) }>
					<ToggleControl
						label={ __( 'Has Title', 'lb' ) }
						checked={ attributes.hasTitle }
						onChange={ () => setAttributes( { hasTitle: ! attributes.hasTitle } ) }
						help={ __( 'Does this section have a title?', 'lb' ) }
					/>
					{ attributes.hasTitle &&
						<>
							<SelectControl
								label={ __( 'Heading Tag', 'lb' ) }
								value={ attributes.headingLevel }
								options={ [
									{ label: 'H1', value: '1' },
									{ label: 'H2', value: '2' },
									{ label: 'H3', value: '3' },
								] }
								onChange={ ( headingLevel: string ) => setAttributes( { headingLevel } ) }
							/>
							<SelectControl
								label={ __( 'Heading Style', 'lb' ) }
								value={ attributes.headingStyle }
								options={ [
									{ label: __( 'Default', 'lb' ), value: '' },
									{ label: 'H1', value: '1' },
									{ label: 'H2', value: '2' },
									{ label: 'H3', value: '3' },
								] }
								onChange={ ( headingStyle: string ) => setAttributes( { headingStyle } ) }
							/>
							<SelectControl
								label={ __( 'Text Alignment', 'lb' ) }
								help={ __( 'Select the text alignment for the title.', 'lb' ) }
								value={ attributes.titleAlignment }
								options={ [
									{ label: 'Center', value: 'center' },
									{ label: 'Left', value: 'left' },
								] }
								onChange={ ( titleAlignment: string ) => setAttributes( { titleAlignment } ) }
							/>
						</>
					}
					<ToggleControl
						label={ __( 'Has Description', 'lb' ) }
						checked={ attributes.hasDescription }
						onChange={ () =>
							setAttributes( { hasDescription: ! attributes.hasDescription } )
						}
						help={ __( 'Does this section have an description?', 'lb' ) }
					/>
					<ToggleControl
						label={ __( 'Has Background', 'lb' ) }
						checked={ attributes.hasBackground }
						onChange={ () => setAttributes( {
							hasBackground: ! attributes.hasBackground,
							hasPadding: ! attributes.hasBackground,
						} ) }
						help={ __( 'Does this section have a background colour?', 'lb' ) }
					/>
					{ attributes.hasBackground &&
						<ColorPaletteControl
							label={ __( 'Background Color', 'lb' ) }
							help={ __( 'Select the background color.', 'lb' ) }
							value={ colors.find( ( color ) => color.slug === attributes.backgroundColor )?.color }
							colors={ colors.filter( ( color ) => [ 'black', 'gray' ].includes( color.slug ) ) }
							onChange={ ( backgroundColor: {
								color: string;
								slug: string;
							} ): void => {
								// Set the background color attribute.
								if ( backgroundColor.slug && [ 'black', 'gray' ].includes( backgroundColor.slug ) ) {
									setAttributes( { backgroundColor: backgroundColor.slug } );
								}
							} }
						/>
					}
					<ToggleControl
						label={ __( 'Is Narrow', 'lb' ) }
						checked={ attributes.isNarrow }
						onChange={ () => setAttributes( {
							isNarrow: ! attributes.isNarrow,
						} ) }
						help={ __( 'Does this section have narrow width?', 'lb' ) }
					/>
					<ToggleControl
						label={ __( 'Has Padding', 'lb' ) }
						checked={ attributes.hasPadding }
						onChange={ () => setAttributes( { hasPadding: ! attributes.hasPadding } ) }
						help={ __( 'Does this section have a padding?', 'lb' ) }
					/>
					<ToggleControl
						label={ __( 'Has CTA', 'lb' ) }
						checked={ attributes.hasCta }
						onChange={ () => setAttributes( { hasCta: ! attributes.hasCta } ) }
						help={ __( 'Does this section have a CTA button?', 'lb' ) }
					/>
				</PanelBody>
			</InspectorControls>
			<Section
				{ ...blockProps }
				background={ attributes.hasBackground }
				backgroundColor={ attributes.backgroundColor }
				padding={ attributes.hasPadding }
				seamless={ attributes.hasBackground }
				narrow={ attributes.isNarrow }
			>
				{ attributes.hasTitle && (
					<div className="section__title-and-cta">
						<RichText
							tagName={ `h${ attributes.headingLevel }` as 'h1' | 'h2' | 'h3' }
							className={ `section__title section__title--${ attributes.titleAlignment } h${ attributes.headingStyle }` }
							placeholder={ __( 'Write title…', 'lb' ) }
							value={ attributes.title }
							onChange={ ( title ) => setAttributes( { title } ) }
							allowedFormats={ [] }
						/>
						{ attributes.hasCta && (
							<div className={
								`section__cta-button ${ 'black' === attributes.backgroundColor && attributes.hasBackground ? 'color-context--dark' : '' }`
							}>
								<LinkButton
									className={ classnames( 'btn', 'btn--color-black', 'btn--outline' ) }
									placeholder={ __( 'Enter CTA Text', 'lb' ) }
									value={ attributes.ctaButton }
									onChange={ ( ctaButton ) => setAttributes( { ctaButton } ) }
								/>
							</div>
						) }
					</div>
				) }
				{ attributes.hasDescription && (
					<RichText
						tagName="p"
						className="section__description"
						placeholder={ __( 'Write description…', 'lb' ) }
						value={ attributes.description }
						onChange={ ( description ) => setAttributes( { description } ) }
						allowedFormats={ [] }
					/>
				) }
				<div>
					<div { ...innerBlocksProps } />
				</div>
			</Section>
		</>
	);
}
