/**
 * WordPress dependencies
 */
import { Tooltip, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * SelectedItems Component
 *
 * Displays selected items that can be removed
 *
 * @param {Object}   props              - Component props
 * @param {Array}    props.items        - Selected items
 * @param {Function} props.onUnselected - Callback when an item is removed
 * @return {JSX.Element} The component
 */
export default function SelectedItems({ items, onUnselected }) {
	return (
		<ul className="aquila-relationship__items">
			{items.map((item, index) => {
				return (
					<li
						key={item.id || index}
						className="aquila-relationship__item"
					>
						<div className="aquila-relationship__item-label">
							{item.label !== ''
								? item.label
								: __('(no title)', 'aquila-theme')}
						</div>
						<div className="aquila-relationship__item-action">
							<Tooltip text={__('Remove', 'aquila-theme')}>
								<Button
									onClick={() => onUnselected(item)}
									icon="dismiss"
								/>
							</Tooltip>
						</div>
					</li>
				);
			})}
		</ul>
	);
}
