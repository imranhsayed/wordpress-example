/**
 * WordPress dependencies
 */
import { dispatch } from '@wordpress/data';
import { store as preferencesStore } from '@wordpress/preferences';
import domReady from '@wordpress/dom-ready';

domReady( () => {
	// Force disable enableChoosePatternModal for all users
	dispatch( preferencesStore ).set( 'core', 'enableChoosePatternModal', false );
} );
