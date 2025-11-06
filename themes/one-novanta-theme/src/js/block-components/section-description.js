/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';

/**
 * Section Description.
 *
 * @param {Object}   props             Component props.
 * @param {string}   props.description Description value.
 * @param {Function} props.onChange    Function to call when description value is changed.
 *
 * @return {JSX.Element} Section description.
 */
const SectionDescription = ( { description, onChange } ) => (
	<RichText
		tagName="p"
		className="one-novanta-section__description"
		placeholder={ __( 'Write description…', 'one-novanta-theme' ) }
		value={ description }
		onChange={ onChange }
		allowedFormats={ [ 'core/bold', 'core/italic', 'core/text-color', 'core/link' ] }
	/>
);

export default SectionDescription;
