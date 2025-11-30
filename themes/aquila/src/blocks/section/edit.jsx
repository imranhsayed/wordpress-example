/**
 * WordPress dependencies
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
	ColorPalette,
} from '@wordpress/components';

/**
 * Internal dependencies
 */
import Section from '../../components/section';
import LinkButton from '../../block-components/LinkButton';

/**
 * External dependencies
 */
import classnames from 'classnames';

// Background colors
export const colors = [
	{ name: __('Black', 'aquila-theme'), color: '#232933', slug: 'black' },
	{ name: __('Gray', 'aquila-theme'), color: '#F5F7FB', slug: 'gray' },
];

/**
 * Edit Component
 *
 * @param {Object}   props               Component properties
 * @param {string}   props.className     Class name
 * @param {Object}   props.attributes    Block attributes
 * @param {Function} props.setAttributes Set block attributes
 */
export default function Edit({ className, attributes, setAttributes }) {
	// Block props
	const blockProps = useBlockProps({
		className: classnames('section', className),
	});
	const innerBlocksProps = useInnerBlocksProps({
		className: 'section__content',
	});

	// Return block
	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Section Options', 'aquila-theme')}>
					<ToggleControl
						label={__('Has Title', 'aquila-theme')}
						checked={attributes.hasTitle}
						onChange={() =>
							setAttributes({ hasTitle: !attributes.hasTitle })
						}
						help={__(
							'Does this section have a title?',
							'aquila-theme'
						)}
					/>
					{attributes.hasTitle && (
						<>
							<SelectControl
								label={__('Heading Tag', 'aquila-theme')}
								value={attributes.headingLevel}
								options={[
									{ label: 'H1', value: '1' },
									{ label: 'H2', value: '2' },
									{ label: 'H3', value: '3' },
								]}
								onChange={(headingLevel) =>
									setAttributes({ headingLevel })
								}
							/>
							<SelectControl
								label={__('Heading Style', 'aquila-theme')}
								value={attributes.headingStyle}
								options={[
									{
										label: __('Default', 'aquila-theme'),
										value: '',
									},
									{ label: 'H1', value: '1' },
									{ label: 'H2', value: '2' },
									{ label: 'H3', value: '3' },
								]}
								onChange={(headingStyle) =>
									setAttributes({ headingStyle })
								}
							/>
							<SelectControl
								label={__('Text Alignment', 'aquila-theme')}
								help={__(
									'Select the text alignment for the title.',
									'aquila-theme'
								)}
								value={attributes.titleAlignment}
								options={[
									{ label: 'Center', value: 'center' },
									{ label: 'Left', value: 'left' },
								]}
								onChange={(titleAlignment) =>
									setAttributes({ titleAlignment })
								}
							/>
						</>
					)}
					<ToggleControl
						label={__('Has Description', 'aquila-theme')}
						checked={attributes.hasDescription}
						onChange={() =>
							setAttributes({
								hasDescription: !attributes.hasDescription,
							})
						}
						help={__(
							'Does this section have a description?',
							'aquila-theme'
						)}
					/>
					<ToggleControl
						label={__('Has Background', 'aquila-theme')}
						checked={attributes.hasBackground}
						onChange={() =>
							setAttributes({
								hasBackground: !attributes.hasBackground,
								hasPadding: !attributes.hasBackground,
							})
						}
						help={__(
							'Does this section have a background colour?',
							'aquila-theme'
						)}
					/>
					{attributes.hasBackground && (
						<>
							<p>{__('Background Color', 'aquila-theme')}</p>
							<ColorPalette
								colors={colors.filter((color) =>
									['black', 'gray'].includes(color.slug)
								)}
								value={
									colors.find(
										(color) =>
											color.slug ===
											attributes.backgroundColor
									)?.color
								}
								onChange={(colorValue) => {
									const selectedColor = colors.find(
										(color) => color.color === colorValue
									);
									if (
										selectedColor &&
										['black', 'gray'].includes(
											selectedColor.slug
										)
									) {
										setAttributes({
											backgroundColor: selectedColor.slug,
										});
									}
								}}
							/>
						</>
					)}
					<ToggleControl
						label={__('Is Narrow', 'aquila-theme')}
						checked={attributes.isNarrow}
						onChange={() =>
							setAttributes({
								isNarrow: !attributes.isNarrow,
							})
						}
						help={__(
							'Does this section have narrow width?',
							'aquila-theme'
						)}
					/>
					<ToggleControl
						label={__('Has Padding', 'aquila-theme')}
						checked={attributes.hasPadding}
						onChange={() =>
							setAttributes({ hasPadding: !attributes.hasPadding })
						}
						help={__(
							'Does this section have padding?',
							'aquila-theme'
						)}
					/>
					<ToggleControl
						label={__('Has CTA', 'aquila-theme')}
						checked={attributes.hasCta}
						onChange={() =>
							setAttributes({ hasCta: !attributes.hasCta })
						}
						help={__(
							'Does this section have a CTA button?',
							'aquila-theme'
						)}
					/>
				</PanelBody>
			</InspectorControls>
			<Section
				{...blockProps}
				background={attributes.hasBackground}
				backgroundColor={attributes.backgroundColor}
				padding={attributes.hasPadding}
				seamless={attributes.hasBackground}
				narrow={attributes.isNarrow}
			>
				{attributes.hasTitle && (
					<div className="section__title-and-cta">
						<RichText
							tagName={`h${attributes.headingLevel}`}
							className={`section__title section__title--${attributes.titleAlignment} ${
								attributes.headingStyle
									? `h${attributes.headingStyle}`
									: ''
							}`}
							placeholder={__(
								'Write title…',
								'aquila-theme'
							)}
							value={attributes.title}
							onChange={(title) => setAttributes({ title })}
							allowedFormats={[]}
						/>
					</div>
				)}
				{attributes.hasDescription && (
					<RichText
						tagName="p"
						className="section__description"
						placeholder={__(
							'Write description…',
							'aquila-theme'
						)}
						value={attributes.description}
						onChange={(description) =>
							setAttributes({ description })
						}
						allowedFormats={[]}
					/>
				)}
				<div>
					<div {...innerBlocksProps} />
				</div>
				{attributes.hasCta && (
					<div
						className={`section__cta-button ${
							'black' === attributes.backgroundColor &&
							attributes.hasBackground
								? 'color-context--dark'
								: ''
						}`}
					>
						<LinkButton
							className={classnames(
								'btn',
								'btn--color-black',
								'btn--outline'
							)}
							placeholder={__(
								'Enter CTA Text',
								'aquila-theme'
							)}
							value={attributes.ctaButton}
							onChange={(ctaButton) =>
								setAttributes({ ctaButton })
							}
						/>
					</div>
				)}
			</Section>
		</>
	);
}
