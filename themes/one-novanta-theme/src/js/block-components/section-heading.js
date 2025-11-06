/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';

/**
 * Section Heading.
 *
 * @param {Object}   props          Component props.
 * @param {string}   props.heading  Heading value.
 * @param {string}   props.level    Heading level.
 * @param {Function} props.onChange Function to call when heading value is changed.
 * @return {JSX.Element} Section heading.
 */
const SectionHeading = ( { heading, level, onChange } ) => (
	<>
		<RichText
			tagName={ `h${ level }` }
			className="one-novanta-section__heading"
			placeholder={ __( 'Write Title…', 'one-novanta-theme' ) }
			value={ heading }
			onChange={ onChange }
			allowedFormats={ [ 'core/bold', 'core/italic', 'core/text-color', 'core/link' ] }
		/>
	</>
);

export default SectionHeading;
