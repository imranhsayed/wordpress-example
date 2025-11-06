/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useSelect, useDispatch } from '@wordpress/data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { registerPlugin } from '@wordpress/plugins';
import { ToggleControl, TextControl } from '@wordpress/components';

/**
 * Component to render the Product deprecation meta fields.
 *
 * @return {JSX.Element} JSX Element
 */
const RenderIsProductDeprecatedMeta = () => {
	/**
	 * Dispatch the action to update meta field.
	 */
	const { editPost } = useDispatch( 'core/editor' );

	/**
	 * Get the current value of meta fields.
	 */
	const isProductDeprecated = useSelect( ( select ) => select( 'core/editor' )?.getEditedPostAttribute( 'meta' )?.is_product_deprecated ?? false );
	const newProductName = useSelect( ( select ) => select( 'core/editor' )?.getEditedPostAttribute( 'meta' )?.new_product_name ?? '' );
	const newProductURL = useSelect( ( select ) => select( 'core/editor' )?.getEditedPostAttribute( 'meta' )?.new_product_url ?? '' );

	return (
		<>
			<ToggleControl
				label={ __( 'Is product deprecated', 'one-novanta-theme' ) }
				checked={ isProductDeprecated }
				className="one-novanta-is-product-deprecated"
				onChange={ ( value ) => editPost( { meta: { is_product_deprecated: value } } ) }
			/>

			{
				isProductDeprecated &&
				<TextControl
					label={ __( 'New product name', 'one-novanta-theme' ) }
					className="one-novanta-new-product-name"
					onChange={ ( value ) => editPost( { meta: { new_product_name: value } } ) }
					value={ newProductName }
				/>
			}

			{
				isProductDeprecated &&
				<TextControl
					label={ __( 'New Product URL', 'one-novanta-theme' ) }
					className="one-novanta-new-product-url"
					onChange={ ( value ) => editPost( { meta: { new_product_url: value } } ) }
					value={ newProductURL }
				/>
			}
		</>
	);
};

/**
 * Main component to render the Product settings sidebar.
 *
 * @return {JSX.Element} JSX Element
 */
const ProductSettingsSidebar = () => {
	// Get current post type.
	const postType = useSelect( ( select ) => select( 'core/editor' ).getCurrentPostType() );

	const allowedPostTypes = [ 'product' ];

	return (
		<>
			{ allowedPostTypes.includes( postType ) && (
				<PluginDocumentSettingPanel
					name="one_novanta_is_product_deprecated"
					title={ __( 'Product Settings', 'one-novanta-theme' ) }
					className="one-novanta-is-product-settings"
				>
					<RenderIsProductDeprecatedMeta />
				</PluginDocumentSettingPanel>
			) }
		</>
	);
};

/**
 * Register the plugin to add the Product settings sidebar.
 */
registerPlugin( 'one-novanta-show-product-settings-sidebar', {
	render: ProductSettingsSidebar,
	icon: null,
} );
