/**
 * WordPress dependencies
 */
import { ToolbarGroup, ToolbarButton } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { pullLeft, pullRight } from '@wordpress/icons';

export default function AlignmentToolbar( { value, onChange, labels = {} } ) {
	return (
		<ToolbarGroup>
			<ToolbarButton
				label={ labels.left || __( 'Align Left', 'one-novanta-theme' ) }
				icon={ pullLeft }
				isPressed={ value === 'left' }
				onClick={ () => onChange( 'left' ) }
			/>
			<ToolbarButton
				label={ labels.right || __( 'Align Right', 'one-novanta-theme' ) }
				icon={ pullRight }
				isPressed={ value === 'right' }
				onClick={ () => onChange( 'right' ) }
			/>
		</ToolbarGroup>
	);
}
