/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import { Placeholder } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Internal dependencies
 */
import InspectorControls from './inspector-controls';

export default function Edit( { attributes, setAttributes } ) {
	const baseClassName = 'related-articles-block';
	const { mode = 'automatic', selectedPosts = [] } = attributes;

	const blockProps = useBlockProps( {
		className: `${ baseClassName } alignfull`,
	} );

	// Show placeholder if manual mode is selected but no posts are selected
	const showPlaceholder = mode === 'manual' && selectedPosts.length === 0;

	return (
		<div { ...blockProps }>
			<InspectorControls
				attributes={ attributes }
				setAttributes={ setAttributes }
			/>

			{ showPlaceholder ? (
				<Placeholder
					icon="grid-view"
					label={ __( 'Related Articles', 'aquila-theme' ) }
					instructions={ __( 'Select posts from the block settings to display them here.', 'aquila-theme' ) }
				/>
			) : (
				<ServerSideRender
					block="aquila/related-articles"
					attributes={ attributes }
				/>
			) }
		</div>
	);
}
