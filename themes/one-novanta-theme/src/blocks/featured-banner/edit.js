/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	BlockControls,
	InnerBlocks,
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';
// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- ToggleGroupControl is required to set appearance.
import { PanelBody, SelectControl, ToggleControl, ToolbarDropdownMenu, __experimentalToggleGroupControl as ToggleGroupControl, __experimentalToggleGroupControlOption as ToggleGroupControlOption } from '@wordpress/components';
import { alignNone, justifyBottom, justifyCenter, justifyTop, stretchWide } from '@wordpress/icons';
import { useEffect } from '@wordpress/element';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Internal dependencies
 */
import { usePostData } from './hooks';
import MediaControls from '../../js/block-components/media-controls';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   props               Block properties.
 * @param {Object}   props.attributes    Block attributes.
 * @param {Function} props.setAttributes Method to update block attributes.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { preHeading, heading, description, imageURL, hasDescription, hasButtons, contentWidth, height, verticalAlign, isDynamic, taxonomy, imageID, overlay } = attributes;

	const blockProps = useBlockProps( {
		className: `one-novanta-feature-banner alignfull one-novanta-feature-banner--${ contentWidth } one-novanta-feature-banner--${ height } one-novanta-feature-banner--vertical-align-${ verticalAlign } has-overlay-${ overlay }`,
	} );

	/**
	 * Returns current active vertical alignment icon.
	 *
	 * @param {string} verticalAlignment Vertical alignment.
	 *
	 * @return {Element} Icon.
	 */
	const getVerticalAlignmentIcon = ( verticalAlignment ) => {
		switch ( verticalAlignment ) {
			case 'top':
				return justifyTop;
			case 'middle':
				return justifyCenter;
			case 'bottom':
				return justifyBottom;
			default:
				setAttributes( { verticalAlign: 'middle' } );
				return justifyCenter;
		}
	};

	const { taxonomies } = usePostData();

	// Set the default taxonomy if not already set.
	useEffect( () => {
		// Return if taxonomy is already set or taxonomies are not yet fetched.
		if ( taxonomy || ! taxonomies?.length ) {
			return;
		}

		setAttributes( { taxonomy: taxonomies[ 0 ].slug } );
	}, [ taxonomies ] ); // eslint-disable-line react-hooks/exhaustive-deps

	/**
	 * Handles the event for selecting media and updates the related attributes with the selected media details.
	 *
	 * @param {Object} media                   The media object containing details of the selected media.
	 * @param {string} [media.url]             The URL of the media if the size-specific URL is not available.
	 * @param {Object} [media.sizes]           A collection of available sizes for the selected media.
	 * @param {Object} [media.sizes.large]     The large version of the media size, if available.
	 * @param {string} [media.sizes.large.url] The URL of the large media size, if available.
	 * @param {number} [media.id]              The unique identifier of the selected media.
	 *
	 * @return {void}
	 */
	const setMediaHandler = ( media ) => {
		// If no media is selected, return early.
		if ( ! media ) {
			return;
		}

		/**
		 * Prepare media url.
		 * Note: This Media parameter only have default image sizes.
		 * Custom image size are not present, therefore we are using large.
		 */
		const mediaUrl = media?.sizes?.large?.url || media?.url || null;

		setAttributes( {
			imageURL: mediaUrl,
			imageID: media?.id ?? 0,
		} );
	};

	/**
	 * Resets the media handler by clearing the associated image data.
	 *
	 * This method removes the image URL and resets the image ID to 0,
	 * effectively clearing any previously selected or set image information.
	 */
	const resetMediaHandler = () => {
		setAttributes( {
			imageURL: '',
			imageID: 0,
		} );
	};

	const mediaControlsProps = isDynamic ? {
		hasImageLabel: __( 'Replace default image', 'one-novanta-theme' ),
		noImageLabel: __( 'Add default image', 'one-novanta-theme' ),
	} : {};

	return (
		<>
			<BlockControls group="other">
				{
					<MediaControls
						imageID={ imageID }
						imageURL={ imageURL }
						onSelectMedia={ setMediaHandler }
						onResetMedia={ resetMediaHandler }
						{ ...mediaControlsProps }
					/>
				}

				<ToolbarDropdownMenu
					icon={ 'default' === contentWidth ? stretchWide : alignNone }
					label={ __( 'Content Width', 'one-novanta-theme' ) }
					controls={ [
						{
							title: __( 'Wide', 'one-novanta-theme' ),
							icon: stretchWide,
							isActive: 'default' === contentWidth,
							onClick: () => setAttributes( { contentWidth: 'default' } ),
						},
						{
							title: __( 'Narrow', 'one-novanta-theme' ),
							icon: alignNone,
							isActive: 'narrow' === contentWidth,
							onClick: () => setAttributes( { contentWidth: 'narrow' } ),
						},
					] }
				/>

				<ToolbarDropdownMenu
					icon={ getVerticalAlignmentIcon( verticalAlign ) }
					label={ __( 'Vertical Alignment', 'one-novanta-theme' ) }
					controls={ [
						{
							title: __( 'Top', 'one-novanta-theme' ),
							icon: justifyTop,
							isActive: 'top' === verticalAlign,
							onClick: () => setAttributes( { verticalAlign: 'top' } ),
						},
						{
							title: __( 'Middle', 'one-novanta-theme' ),
							icon: justifyCenter,
							isActive: 'middle' === verticalAlign,
							onClick: () => setAttributes( { verticalAlign: 'middle' } ),
						},
						{
							title: __( 'Bottom', 'one-novanta-theme' ),
							icon: justifyBottom,
							isActive: 'bottom' === verticalAlign,
							onClick: () => setAttributes( { verticalAlign: 'bottom' } ),
						},
					] }
				/>
			</BlockControls>

			<InspectorControls>
				<PanelBody title={ __( 'Overlay', 'one-novanta-theme' ) }>
					<ToggleGroupControl
						__next40pxDefaultSize
						__nextHasNoMarginBottom
						value={ overlay }
						onChange={ ( value ) => {
							setAttributes( { overlay: value } );
						} }
					>
						<ToggleGroupControlOption
							label={ __( 'Dark', 'one-novanta-theme' ) }
							value="dark"
						/>
						<ToggleGroupControlOption
							label={ __( 'Light', 'one-novanta-theme' ) }
							value="light"
						/>
					</ToggleGroupControl>
				</PanelBody>

				<PanelBody title={ __( 'Feature Banner Options', 'one-novanta-theme' ) }>
					<ToggleControl
						label={ __( 'Is Dynamic', 'one-novanta-theme' ) }
						checked={ isDynamic }
						onChange={ () => setAttributes( { isDynamic: ! isDynamic } ) }
					/>

					{
						isDynamic &&
						<SelectControl
							label={ __( 'Category to display', 'one-novanta-theme' ) }
							value={ taxonomy }
							options={ taxonomies?.map(
								( tax ) => ( { label: tax?.name ?? '', value: tax?.slug ?? '' } ),
							) ?? [] }
							onChange={ ( value ) => setAttributes( { taxonomy: value } ) }
						/>
					}

					<ToggleControl
						label={ isDynamic ? __( 'Show Publish Date', 'one-novanta-theme' ) : __( 'Show Description', 'one-novanta-theme' ) }
						checked={ hasDescription }
						onChange={ () => setAttributes( { hasDescription: ! hasDescription } ) }
					/>

					{
						! isDynamic &&
						<ToggleControl
							label={ __( 'Show Buttons', 'one-novanta-theme' ) }
							checked={ hasButtons }
							onChange={ () => setAttributes( { hasButtons: ! hasButtons } ) }
						/>
					}

					<SelectControl
						label={ __( 'Height', 'one-novanta-theme' ) }
						value={ height }
						options={ [
							{ label: __( 'Small', 'one-novanta-theme' ), value: 'default' },
							{ label: __( 'Large', 'one-novanta-theme' ), value: 'large' },
						] }
						onChange={ ( value ) => setAttributes( { height: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

			{
				isDynamic &&
				<div { ...blockProps }>
					<ServerSideRender
						block="one-novanta/featured-banner"
						attributes={ attributes }
					/>
				</div>
			}

			{
				! isDynamic &&
				<div { ...blockProps }>
					<figure className="one-novanta-feature-banner__image-wrap">
						{ imageURL && <img src={ imageURL } alt="" /> }
					</figure>

					<div className="one-novanta-feature-banner__content">
						<div className="one-novanta-feature-banner__content-wrap">
							<RichText
								tagName="p"
								className="one-novanta-feature-banner__pre-heading has-medium-font-size"
								placeholder={ __( 'Write Pre-Heading…', 'one-novanta-theme' ) }
								value={ preHeading }
								onChange={ ( value ) => setAttributes( { preHeading: value } ) }
								allowedFormats={ [] }
							/>

							<RichText
								tagName="h1"
								className="one-novanta-feature-banner__heading has-display-font-size"
								placeholder={ __( 'Write Heading…', 'one-novanta-theme' ) }
								value={ heading }
								onChange={ ( value ) => setAttributes( { heading: value } ) }
								allowedFormats={ [] }
							/>

							{
								hasDescription &&
								<RichText
									tagName="p"
									className="one-novanta-feature-banner__description"
									placeholder={ __( 'Write Description…', 'one-novanta-theme' ) }
									value={ description }
									onChange={ ( value ) => setAttributes( { description: value } ) }
									allowedFormats={ [] }
								/>
							}

							{
								hasButtons &&
								<InnerBlocks
									allowedBlocks={ [] }
									template={ [
										[
											'core/buttons',
											{},
											[
												[
													'core/button',
													{
														text: __( 'Discover', 'one-novanta-theme' ),
														className: 'has-arrow is-style-outline',
													},
												],
												[
													'core/button',
													{
														text: __( 'Watch Video', 'one-novanta-theme' ),
														className: 'has-arrow is-style-fill',
													},
												],
											],
										],
									] }
								/>
							}
						</div>
					</div>
				</div>
			}
		</>
	);
}
