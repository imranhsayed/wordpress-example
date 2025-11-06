/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { addFilter } = wp.hooks;
const { useSelect } = wp.data;
const { useEntityProp } = wp.coreData;
const { createHigherOrderComponent } = wp.compose;
const {
	FocalPointPicker,
	PanelBody,
	PanelRow,
	__experimentalVStack: VStack,
} = wp.components;

/**
 * Constants
 *
 * Supported post types for the focal point picker.
 */
const SUPPORTED_POST_TYPES = [ 'post', 'novanta_application' ];

/**
 * Add Focal Point Picker to Featured Image on posts.
 *
 * @param {Function} PostFeaturedImage Featured Image component.
 *
 * @return {Function} PostFeaturedImage Modified Featured Image component.
 */
const wrapPostFeaturedImage = createHigherOrderComponent(
	( PostFeaturedImage ) => {
		return ( props ) => {
			const { media } = props;
			const [ postType ] = useSelect( ( select ) => {
				const { getCurrentPostType } = select( 'core/editor' );
				return [ getCurrentPostType() ];
			} );

			// Get the meta for the attachment (featured image)
			const [ meta, setMeta ] = useEntityProp( 'root', 'media', 'meta', media?.id );

			const setFeaturedImageMeta = ( val ) => {
				setMeta(
					Object.assign( {}, meta, {
						focal_point: val,
					} ),
				);
			};

			if ( postType && SUPPORTED_POST_TYPES.includes( postType ) && media && media.source_url ) {
				const url = media.source_url;

				return (
					<Fragment>
						<PostFeaturedImage { ...props } />
						<PanelBody
							name="featured-image-focal-point"
							title={ __( 'Focal point picker', 'one-novanta-theme' ) }
							initialOpen={ false }
							className="featured-image-focal-point"
						>
							<PanelRow>
								<FocalPointPicker
									url={ url }
									value={ meta?.focal_point || { x: 0.5, y: 0.5 } }
									__nextHasNoMarginBottom={ true }
									onChange={ ( newFocalPoint ) =>
										setFeaturedImageMeta( newFocalPoint )
									}
								/>
							</PanelRow>
							<PanelRow>
								<VStack>
									<div className="focal-point-preview-label">{ __( 'Card Thumbnail', 'one-novanta-theme' ) }</div>
									<img
										alt={ __( 'Focal Point Preview', 'one-novanta-theme' ) }
										className="components-focal-point-picker__media components-focal-point-picker__media--image"
										style={ {
											objectFit: 'cover',
											aspectRatio: '1',
											objectPosition: `${
												meta?.focal_point.x * 100
											}% ${
												meta?.focal_point.y * 100
											}%`,
										} }
										src={ media.source_url }
									/>
								</VStack>
							</PanelRow>
						</PanelBody>
					</Fragment>
				);
			}

			return <PostFeaturedImage { ...props } />;
		};
	},
	'wrapPostFeaturedImage',
);

addFilter(
	'editor.PostFeaturedImage',
	'novanta/featured-image-control',
	wrapPostFeaturedImage,
);
