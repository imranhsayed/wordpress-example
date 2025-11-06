/**
 * WordPress dependencies
 */
/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import {
	useState,
} from '@wordpress/element';
import {
	InspectorControls,
	getColorObjectByColorValue,
	getColorObjectByAttributeValues,
} from '@wordpress/block-editor';
import {
	PanelBody,
	ToggleControl,
	SelectControl,
	ColorPalette,
} from '@wordpress/components';

const SectionInspectorControls = ( {
	attributes,
	setAttributes,
} ) => {
	// Predefined theme colors.
	const themeColors = useSelect( 'core/block-editor' ).getSettings().colors;

	// Extract background colors from theme colors.
	const backgroundColors = themeColors.filter(
		( color ) => [ 'background', 'secondary' ].includes( color.slug ),
	);

	// Section background color.
	const [ backgroundColor, setBackgroundColor ] = useState( ( getColorObjectByAttributeValues( backgroundColors, attributes.backgroundColor, '' ) )?.color ?? '' );

	return (
		<InspectorControls>
			<PanelBody title={ __( 'Section Options', 'one-novanta-theme' ) }>
				<ToggleControl
					label={ __( 'Has Title', 'one-novanta-theme' ) }
					checked={ attributes.hasHeading }
					onChange={ () => {
						setAttributes( { hasHeading: ! attributes.hasHeading } );
					} }
					help={ __( 'Does this section have a title?', 'one-novanta-theme' ) }
				/>

				<ToggleControl
					label={ __( 'Has Description', 'one-novanta-theme' ) }
					checked={ attributes.hasDescription }
					onChange={ () =>
						setAttributes( { hasDescription: ! attributes.hasDescription } )
					}
					help={ __( 'Does this section has a description?', 'one-novanta-theme' ) }
				/>

				{
					attributes.hasHeading &&
					<>
						<SelectControl
							label={ __( 'Title Tag', 'one-novanta-theme' ) }
							value={ attributes.headingLevel }
							options={ [
								{ label: 'H2', value: '2' },
								{ label: 'H3', value: '3' },
								{ label: 'H4', value: '4' },
							] }
							onChange={ ( headingLevel ) => setAttributes( { headingLevel } ) }
						/>
					</>
				}

				{
					( attributes.hasHeading || attributes.hasDescription ) &&
					<>
						<SelectControl
							label={ __( 'Title/Description Text Alignment', 'one-novanta-theme' ) }
							help={ __( 'Select the text alignment for title.', 'one-novanta-theme' ) }
							value={ attributes.headingAlignment }
							options={ [
								{ label: __( 'Left', 'one-novanta-theme' ), value: 'left' },
								{ label: __( 'Center', 'one-novanta-theme' ), value: 'center' },
								{ label: __( 'Right', 'one-novanta-theme' ), value: 'right' },
							] }
							onChange={ ( headingAlignment ) => setAttributes( { headingAlignment } ) }
						/>

						<hr />
					</>
				}

				<SelectControl
					label={ __( 'Width', 'one-novanta-theme' ) }
					help={ __( 'Section Width.', 'one-novanta-theme' ) }
					value={ attributes.align }
					options={ [
						{ label: __( 'Narrow', 'one-novanta-theme' ), value: 'narrow' },
						{ label: __( 'Wide', 'one-novanta-theme' ), value: 'wide' },
						{ label: __( 'Full', 'one-novanta-theme' ), value: 'full' },
					] }
					onChange={ ( align ) => setAttributes( { align } ) }
				/>

				<SelectControl
					label={ __( 'Spacing', 'one-novanta-theme' ) }
					help={ __( 'Top and Bottom Spacing.', 'one-novanta-theme' ) }
					value={ attributes.spacing }
					options={ [
						{ label: __( 'Small', 'one-novanta-theme' ), value: 'small' },
						{ label: __( 'Medium', 'one-novanta-theme' ), value: 'medium' },
						{ label: __( 'Large', 'one-novanta-theme' ), value: 'large' },
					] }
					onChange={ ( spacing ) => setAttributes( { spacing } ) }
				/>

				<p>{ __( 'Section Background', 'one-novanta-theme' ) }</p>
				<ColorPalette
					colors={ backgroundColors }
					value={ backgroundColor }
					disableCustomColors={ true }
					onChange={ ( background ) => {
						const color = getColorObjectByColorValue( backgroundColors, background );
						setAttributes( { backgroundColor: color?.slug ?? '' } );
						setBackgroundColor( background ?? '' );
					} }
				/>
			</PanelBody>
		</InspectorControls>
	);
};

export default SectionInspectorControls;
