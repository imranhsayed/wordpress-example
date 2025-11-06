/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { PanelBody, SelectControl } from '@wordpress/components';

// List of available heading level options.
const HeadingLevelOptions = [
	{ label: 'H1', value: 'h1' },
	{ label: 'H2', value: 'h2' },
	{ label: 'H3', value: 'h3' },
	{ label: 'H4', value: 'h4' },
	{ label: 'H5', value: 'h5' },
	{ label: 'H6', value: 'h6' },
];

const HeadingLevel = ( { headingLevel, setHeadingLevel } ) => (
	<PanelBody title={ __( 'Heading Settings', 'one-novanta-theme' ) } >
		<SelectControl
			label={ __( 'Heading Level', 'one-novanta-theme' ) }
			value={ headingLevel }
			options={ HeadingLevelOptions }
			onChange={ ( value ) => setHeadingLevel( value ) }
			help={ __( 'The selected heading level will be applied to headings rendered by this block and any nested blocks that support it.', 'one-novanta-theme' ) }
		/>
	</PanelBody>
);

export default HeadingLevel;
