/**
 * WordPress dependencies
 */
import { useState, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import SearchItems from './SearchItems';
import SelectedItems from './SelectedItems';

const typingDelay = 300;
let typingDelayTimeout = null;

/**
 * Selector Component
 *
 * Displays search interface and selected items in a two-panel layout
 *
 * @param {Object} props - Component props
 * @param {number} props.maxItems - Maximum number of items that can be selected
 * @param {Function} props.onSelect - Callback when selection changes
 * @param {Array} props.items - Currently selected items
 * @param {Function} props.searchQuery - Function to search for items
 * @returns {JSX.Element} The component
 */
export default function Selector( { maxItems, onSelect, items, searchQuery } ) {
	const [ results, setResults ] = useState( [] );
	const [ searching, setSearching ] = useState( false );

	useEffect( () => {
		triggerSearch();
	}, [] );

	const triggerTyping = ( e ) => {
		clearTimeout( typingDelayTimeout );
		typingDelayTimeout = setTimeout( triggerSearch, typingDelay, e.target.value );
	};

	const triggerSearch = ( query = '' ) => {
		setSearching( true );
		searchQuery( query ).then( ( newResults ) => {
			setSearching( false );
			setResults( newResults );
		} );
	};

	return (
		<div className="aquila-relationship">
			<div className="aquila-relationship__search-container">
				<input
					type="text"
					className="aquila-relationship__search"
					placeholder={ __( 'Search', 'aquila-theme' ) }
					onChange={ triggerTyping }
				/>
			</div>
			<div className="aquila-relationship__panel">
				<div className="aquila-relationship__panel__search-items">
					<SearchItems
						disabled={ maxItems > 0 && items.length >= maxItems }
						items={ results }
						loading={ searching }
						selected={ items }
						onSelected={ ( item ) => onSelect( [ ...items, item ] ) }
					/>
				</div>
				<div className="aquila-relationship__panel__selected-items">
					<SelectedItems
						items={ items }
						onUpdated={ ( newItems ) => onSelect( newItems ) }
						onUnselected={ ( item ) =>
							onSelect( items.filter( ( thing ) => thing.value !== item.value ) )
						}
					/>
				</div>
			</div>
		</div>
	);
}
