/**
 * WordPress dependencies
 */
import { useState, useEffect } from '@wordpress/element';
import { Button, Modal, Spinner, BaseControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import Selector from './Selector';
import './style.scss';

/**
 * Relationship Component
 *
 * A reusable component that displays a button to open a modal for selecting items
 *
 * @param {Object}   props              - Component props
 * @param {Array}    props.initialItems - Initial selected items
 * @param {string}   props.label        - Label for the control
 * @param {Function} props.searchQuery  - Function to search for items
 * @param {string}   props.help         - Help text
 * @param {string}   props.buttonLabel  - Label for the button
 * @param {string}   props.modalTitle   - Title for the modal
 * @param {boolean}  props.minimal      - Whether to show selected items or not
 * @param {number}   props.max          - Maximum number of items that can be selected
 * @param {Function} props.onSelect     - Callback when items are selected
 * @return {JSX.Element} The component
 */
export default function Relationship({
	initialItems = [],
	label,
	searchQuery,
	help,
	buttonLabel = __('Select Posts', 'aquila-theme'),
	modalTitle = __('Select Posts', 'aquila-theme'),
	minimal = false,
	max = -1,
	onSelect,
}) {
	const [items, setItems] = useState([]);
	const [userSelection, setUserSelection] = useState([]);
	const [loading, setLoading] = useState(true);
	const [modalOpen, setModalOpen] = useState(false);

	useEffect(() => {
		setItems(initialItems);
		setLoading(false);
	}, [initialItems]);

	const selectItems = () => {
		setItems(userSelection);
		setModalOpen(false);
		if (onSelect) {
			onSelect(userSelection.map((item) => item.value));
		}
	};

	const openModal = () => {
		setUserSelection(items);
		setModalOpen(true);
	};

	return (
		<BaseControl
			id="aquila-relationship-control"
			label={label}
			help={help}
			className="aquila-relationship"
		>
			<Button
				variant="secondary"
				isBusy={minimal && loading}
				onClick={openModal}
			>
				{buttonLabel}
			</Button>
			{!minimal && items.length > 0 && (
				<ul
					className={`aquila-relationship__selected-items${loading ? ' aquila-relationship__selected-items--loading' : ''}`}
				>
					{loading && (
						<li>
							<Spinner />
						</li>
					)}
					{!loading &&
						items.length > 0 &&
						items.map((item, index) => {
							if (index === 3) {
								return (
									<li key={4}>
										... {items.length - 3}{' '}
										{__('more', 'aquila-theme')}
									</li>
								);
							} else if (index > 3) {
								return null;
							}
							return <li key={index}>✓ {item.label}</li>;
						})}
				</ul>
			)}
			{modalOpen && (
				<Modal
					title={modalTitle}
					className="aquila-relationship__modal"
					onRequestClose={() => setModalOpen(false)}
				>
					<Selector
						maxItems={max}
						onSelect={(newItems) => setUserSelection(newItems)}
						items={userSelection}
						searchQuery={searchQuery}
					/>
					<div className="aquila-relationship__modal__actions">
						<Button variant="primary" onClick={selectItems}>
							{__('Select', 'aquila-theme')}
						</Button>
					</div>
				</Modal>
			)}
		</BaseControl>
	);
}
