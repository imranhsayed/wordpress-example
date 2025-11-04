/**
 * WordPress dependencies
 */
import { Spinner, Icon } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * SearchItems Component
 *
 * Displays search results that can be added to selection
 *
 * @param {Object}   props            - Component props
 * @param {boolean}  props.disabled   - Whether adding items is disabled
 * @param {Array}    props.items      - Search result items
 * @param {boolean}  props.loading    - Whether search is in progress
 * @param {Array}    props.selected   - Currently selected items
 * @param {Function} props.onSelected - Callback when an item is selected
 * @return {JSX.Element} The component
 */
export default function SearchItems({
	disabled,
	items,
	loading,
	selected,
	onSelected,
}) {
	const ulClasses = [
		'aquila-relationship__items',
		'aquila-relationship__items--search',
		loading ? 'aquila-relationship__items--loading' : '',
		disabled ? 'aquila-relationship__items--disabled' : '',
	]
		.filter(Boolean)
		.join(' ');

	return (
		<ul className={ulClasses}>
			{loading && <Spinner />}
			{items.map((item) => {
				const itemSelected = selected.find((sel) => sel.id === item.id);
				const liClasses = [
					'aquila-relationship__item',
					itemSelected ? 'aquila-relationship__item--selected' : '',
				]
					.filter(Boolean)
					.join(' ');

				const handleSelect = () => {
					if (!itemSelected) {
						onSelected(item);
					}
				};

				return (
					// eslint-disable-next-line jsx-a11y/no-noninteractive-element-interactions, jsx-a11y/click-events-have-key-events
					<li
						key={item.id}
						className={liClasses}
						tabIndex={0}
						onClick={handleSelect}
						onKeyPress={(e) => {
							if (e.key === 'Enter' || e.key === ' ') {
								e.preventDefault();
								handleSelect();
							}
						}}
					>
						<div className="aquila-relationship__item-label">
							{item.label !== ''
								? item.label
								: __('(no title)', 'aquila-theme')}
						</div>
						<div className="aquila-relationship__item-action">
							<Icon icon="arrow-right-alt2" />
						</div>
					</li>
				);
			})}
		</ul>
	);
}
