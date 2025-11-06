/**
 * WordPress dependencies
 */
import { InspectorControls as BaseInspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function InspectorControls( { attributes, setAttributes } ) {
	return (
		<BaseInspectorControls>
			<PanelBody title={ __( 'Two Columns Option', 'one-novanta-theme' ) }>
				<ToggleControl
					__nextHasNoMarginBottom
					label={ __(
						'Reverse column order on mobile',
						'one-novanta-theme',
					) }
					help={
						attributes.reverseMobileOrder
							? __(
								'Second column will appear first on mobile.',
								'one-novanta-theme',
							)
							: __(
								'Default column order will be preserved.',
								'one-novanta-theme',
							)
					}
					checked={ attributes.reverseMobileOrder }
					onChange={ ( value ) =>
						setAttributes( { reverseMobileOrder: value } )
					}
				/>
			</PanelBody>
		</BaseInspectorControls>
	);
}
