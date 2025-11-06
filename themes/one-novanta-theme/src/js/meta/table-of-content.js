/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import { registerPlugin } from '@wordpress/plugins';
import { ToggleControl } from '@wordpress/components';

/**
 * Component to render the Show Table of Content toggle.
 *
 * @return {JSX.Element} JSX Element
 */
const RenderShowTableOfContentMeta = () => {
	/**
	 * Dispatch the action to update the show_table_of_content meta field.
	 */
	const { editPost } = useDispatch( 'core/editor' );

	/**
	 * Get the current value of the show_table_of_content meta field.
	 */
	const showTableOfContent = useSelect( ( select ) => select( 'core/editor' )?.getEditedPostAttribute( 'meta' )?.show_table_of_content ?? true );

	return (
		<ToggleControl
			label={ __( 'Show Table of Content', 'one-novanta-theme' ) }
			checked={ showTableOfContent }
			onChange={ ( value ) => editPost( { meta: { show_table_of_content: value } } ) }
		/>
	);
};

/**
 * Main component to render the PluginPostStatusInfo sidebar.
 *
 * @return {JSX.Element} JSX Element
 */
const BlogShowTableOfContentSidebar = () => {
	// Get current post type.
	const postType = useSelect( ( select ) =>
		select( 'core/editor' ).getCurrentPostType(),
	);

	const allowedPostTypes = [ 'post' ];

	return (
		<>
			{ allowedPostTypes.includes( postType ) && (
				<PluginDocumentSettingPanel
					name="one_novanta_show_table_of_content"
					title={ __( 'Table of Content', 'one-novanta-theme' ) }
					className="one-novanta-show-table-of-content"
				>
					<RenderShowTableOfContentMeta />
				</PluginDocumentSettingPanel>
			) }
		</>
	);
};

/**
 * Register the plugin to add the Table of Content sidebar.
 */
registerPlugin( 'one-novanta-show-table-of-content', {
	render: BlogShowTableOfContentSidebar,
	icon: null,
} );
