/**
 * Internal dependencies
 */
import SectionInspectorControls from './section-inspector-controls';
import SectionHeading from './section-heading';
import SectionDescription from './section-description';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';

export const Section = ( {
	attributes,
	setAttributes,
	children,
	className,
} ) => {
	// Block props.
	const blockProps = useBlockProps(
		{
			className: classnames(
				'one-novanta-section alignfull is-layout-constrained',
				{
					[ `one-novanta-section--has-background one-novanta-section--background--${ attributes.backgroundColor }` ]: attributes.backgroundColor, // Add background color.
					[ `one-novanta-section--spacing--${ attributes.spacing }` ]: attributes.spacing, // Add spacing.
				},
				className,
			),
		},
	);

	return (
		<>
			<SectionInspectorControls attributes={ attributes } setAttributes={ setAttributes } />
			<div { ...blockProps }>
				{
					( attributes.hasHeading || attributes.hasDescription ) &&
					<div className={ `one-novanta-section__header one-novanta-section__header--align-${ attributes.headingAlignment } alignwide` }>
						{
							attributes.hasHeading &&
							<SectionHeading
								heading={ attributes.heading }
								level={ attributes.headingLevel || 2 }
								alignment={ attributes.headingAlignment }
								onChange={ ( heading ) => setAttributes( { heading } ) }
							/>
						}

						{
							attributes.hasDescription &&
							<SectionDescription
								description={ attributes.description }
								alignment={ attributes.headingAlignment }
								onChange={ ( description ) => setAttributes( { description } ) }
							/>
						}
					</div>
				}

				<div className={ `one-novanta-section__content align${ attributes.align }` }>
					{ children }
				</div>
			</div>
		</>
	);
};
