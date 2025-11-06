/**
 * Dynamic Country-State Fields for GravityForms.
 *
 * Handles the dynamic population of state fields based on country selection
 * in GravityForms address fields.
 */
( function() {
	'use strict';

	/**
	 * Check if GFDynamicCountryState is available globally, otherwise create empty placeholder.
	 */
	const GFDynamicCountryState = window.GFDynamicCountryState || {
		countries: {},
		ajaxUrl: '',
		nonce: '',
	};

	/**
	 * DynamicCountryState object for handling the dynamic functionality.
	 */
	const DynamicCountryState = {
		// Countries that should show state field
		showStateForCountries: [ 'US', 'CA' ],

		/**
		 * Initialize the functionality.
		 */
		init() {
			this.bindEvents();
			this.initCountryDropdowns();
		},

		/**
		 * Bind event listeners.
		 */
		bindEvents() {
			// Listen for country dropdown changes.
			document.addEventListener( 'change', ( e ) => {
				if ( e.target.classList.contains( 'gf-dynamic-country' ) ) {
					this.handleCountryChange( e );
				}
			} );

			// Handle dynamic form additions with MutationObserver.
			const observer = new MutationObserver( ( mutations ) => {
				for ( const mutation of mutations ) {
					if ( mutation.type === 'childList' && mutation.addedNodes.length > 0 ) {
						this.processAddedNodes( mutation.addedNodes );
					}
				}
			} );

			// Listen for Gravity Forms render events.
			document.addEventListener( 'gform_post_render', ( e ) => {
				setTimeout( () => this.processFormRender( e ), 100 );
			} );

			// Start observing DOM changes.
			observer.observe( document.body, {
				childList: true,
				subtree: true,
			} );

			// Handle initial page load forms.
			document.addEventListener( 'DOMContentLoaded', () => {
				this.processValidationErrors();
			} );
		},

		/**
		 * Process added DOM nodes.
		 * @param {NodeList} nodes - Nodes added to the DOM
		 */
		processAddedNodes( nodes ) {
			for ( const node of nodes ) {
				if ( node.nodeType !== Node.ELEMENT_NODE ) {
					continue;
				}

				const forms = node.tagName === 'FORM' ? [ node ] : node.querySelectorAll( 'form[id^="gform_"]' );
				if ( ! forms.length ) {
					continue;
				}

				forms.forEach( ( form ) => {
					setTimeout( () => {
						this.initCountryDropdowns();
						this.processCountryFields( form.querySelectorAll( '.gf-dynamic-country' ) );
					}, 100 );
				} );
			}
		},

		/**
		 * Process form after render.
		 * @param {Event} e - The render event
		 */
		processFormRender( e ) {
			this.initCountryDropdowns();

			const formId = e.detail?.formId;
			if ( formId ) {
				const form = document.getElementById( `gform_${ formId }` );
				if ( form ) {
					this.processCountryFields( form.querySelectorAll( '.gf-dynamic-country' ) );
				}
			}
		},

		/**
		 * Process forms with validation errors.
		 */
		processValidationErrors() {
			document.querySelectorAll( '.gform_validation_error' ).forEach( ( form ) => {
				const formId = form.id?.replace( 'gform_', '' );
				if ( ! formId ) {
					return;
				}

				setTimeout( () => {
					const formElement = document.getElementById( `gform_${ formId }` );
					if ( formElement ) {
						this.processCountryFields( formElement.querySelectorAll( '.gf-dynamic-country' ) );
					}
				}, 100 );
			} );
		},

		/**
		 * Process country fields with values.
		 * @param {NodeList} countryFields - List of country fields
		 */
		processCountryFields( countryFields ) {
			countryFields.forEach( ( countryEl ) => {
				if ( countryEl.value ) {
					this.handleCountryChange( { target: countryEl } );
				}
			} );
		},

		/**
		 * Initialize country dropdowns.
		 */
		initCountryDropdowns() {
			document.querySelectorAll( '.gf-dynamic-country' ).forEach( ( countryEl ) => {
				const targetSelector = countryEl.getAttribute( 'data-target' );
				if ( ! targetSelector ) {
					return;
				}

				// Find state field in form first, then globally.
				const form = countryEl.closest( 'form' );
				const stateEl = form
					? form.querySelector( `.${ targetSelector }` )
					: document.querySelector( `.${ targetSelector }` );

				if ( ! stateEl ) {
					return;
				}

				this.setupStateField( stateEl );

				const currentValue = countryEl.value;
				const addressContainer = this.findAddressContainer( stateEl );

				// Set initial visibility.
				this.toggleStateVisibility(
					addressContainer,
					currentValue && this.showStateForCountries.includes( currentValue ),
				);

				// Trigger change event for pre-selected countries.
				if ( currentValue ) {
					setTimeout( () => {
						countryEl.dispatchEvent( new Event( 'change' ) );
					}, 100 );
				}

				// Handle validation scenarios.
				const isValidatedForm = countryEl.closest( '.gform_validation_error' );
				if ( isValidatedForm && currentValue ) {
					setTimeout( () => this.handleCountryChange( { target: countryEl } ), 50 );
				}
			} );
		},

		/**
		 * Setup state field based on its current form.
		 * @param {HTMLElement} stateEl - The state field
		 */
		setupStateField( stateEl ) {
			if ( stateEl.tagName === 'INPUT' ) {
				this.convertInputToSelect( stateEl );
			} else if ( stateEl.classList.contains( 'gf-dynamic-state-convert' ) ) {
				stateEl.classList.remove( 'gf-dynamic-state-convert' );
				stateEl.classList.add( 'gf-dynamic-state' );
			} else if ( stateEl.tagName === 'SELECT' && ! stateEl.classList.contains( 'gf-dynamic-state' ) ) {
				stateEl.classList.add( 'gf-dynamic-state' );
			}
		},

		/**
		 * Convert input to select dropdown.
		 * @param {HTMLElement} inputEl - Input to convert
		 * @return {HTMLElement} New select element
		 */
		convertInputToSelect( inputEl ) {
			const currentValue = inputEl.value;
			const selectEl = document.createElement( 'select' );

			// Copy attributes.
			[ 'id', 'name', 'tabindex', 'required' ].forEach( ( attr ) => {
				if ( inputEl.hasAttribute( attr ) ) {
					selectEl.setAttribute( attr, inputEl.getAttribute( attr ) );
				}
			} );

			// Set classes.
			selectEl.className = ( inputEl.className || '' )
				.replace( 'gf-dynamic-state-convert', '' ) +
                ' gf-dynamic-state';

			// Copy ARIA attributes.
			Array.from( inputEl.attributes )
				.filter( ( attr ) => attr.name.startsWith( 'aria-' ) )
				.forEach( ( attr ) => selectEl.setAttribute( attr.name, attr.value ) );

			// Add default option.
			const placeholder = inputEl.placeholder || 'Select a state/province';
			selectEl.innerHTML = `<option value="">${ placeholder }</option>`;

			// Add current value option if exists.
			if ( currentValue ) {
				const option = document.createElement( 'option' );
				option.value = currentValue;
				option.textContent = currentValue;
				option.selected = true;
				selectEl.appendChild( option );
			}

			// Replace input with select.
			inputEl.parentNode.replaceChild( selectEl, inputEl );
			return selectEl;
		},

		/**
		 * Handle country change.
		 * @param {Event} e - Change event
		 */
		handleCountryChange( e ) {
			const countryEl = e.target;
			const targetSelector = countryEl.dataset.target;

			// Find state field - first in form, then globally.
			const form = countryEl.closest( 'form' );
			const stateEl = form
				? form.querySelector( `.${ targetSelector }` )
				: document.querySelector( `.${ targetSelector }` );

			if ( ! stateEl ) {
				return;
			}

			const country = countryEl.value;
			const addressContainer = this.findAddressContainer( stateEl );

			// Handle empty country.
			if ( ! country ) {
				stateEl.innerHTML = '<option value="">Select a country</option>';
				this.toggleStateVisibility( addressContainer, false );
				return;
			}

			// Get country code.
			let countryCode = country;
			if ( country.length > 2 ) {
				// Try to find code by name.
				Object.entries( GFDynamicCountryState.countries ).some( ( [ code, data ] ) => {
					if ( data.name === country ) {
						countryCode = code;
						return true;
					}
					return false;
				} );
			}

			const currentState = stateEl.value;
			const shouldShowState = this.showStateForCountries.includes( countryCode );

			// Update visibility.
			this.toggleStateVisibility( addressContainer, shouldShowState );

			if ( shouldShowState ) {
				this.loadStatesForCountry( countryCode, stateEl, currentState );
				this.adjustLayoutForVisibleState( stateEl );
			} else {
				// Add placeholder for non-supported countries.
				stateEl.innerHTML = '<option value="">Not applicable</option>';
				this.adjustLayoutForHiddenState( stateEl );
			}
		},

		/**
		 * Load states for a country.
		 * @param {string}      countryCode  - Country code
		 * @param {HTMLElement} stateEl      - State element
		 * @param {string}      currentState - Current value
		 */
		loadStatesForCountry( countryCode, stateEl, currentState ) {
			const countryData = GFDynamicCountryState.countries[ countryCode ];

			if ( countryData?.states?.length > 0 ) {
				// Use cached states.
				this.populateStates( countryCode, stateEl, countryData.states, currentState );
			} else {
				// Fetch states via AJAX.
				this.fetchStates( countryCode, stateEl );
			}
		},

		/**
		 * Adjust layout for visible state field.
		 * @param {HTMLElement} stateEl - State element
		 */
		adjustLayoutForVisibleState( stateEl ) {
			const stateParent = stateEl.parentNode;
			if ( ! stateParent ) {
				return;
			}

			stateParent.style.display = 'unset';

			const nextSibling = stateParent.nextElementSibling;
			if ( nextSibling && window.getComputedStyle( stateParent ).gridColumn === '2 / 3' ) {
				nextSibling.style.gridColumn = '1 / 2';
			}
		},

		/**
		 * Adjust layout for hidden state field.
		 * @param {HTMLElement} stateEl - State element
		 */
		adjustLayoutForHiddenState( stateEl ) {
			const stateParent = stateEl.parentNode;
			if ( ! stateParent ) {
				return;
			}

			stateParent.style.display = 'none';

			const nextSibling = stateParent.nextElementSibling;
			if ( nextSibling && window.getComputedStyle( stateParent ).gridColumn === '2 / 3' ) {
				nextSibling.style.gridColumn = '2 / 3';
			}
		},

		/**
		 * Find the address container.
		 * @param {HTMLElement} stateEl - State element
		 * @return {HTMLElement|null} Address container
		 */
		findAddressContainer( stateEl ) {
			let element = stateEl;
			while ( element ) {
				if ( element.classList.contains( 'address_state' ) ) {
					return element.closest( '.ginput_container_address' );
				}
				element = element.parentElement;
			}
			return null;
		},

		/**
		 * Toggle state visibility.
		 * @param {HTMLElement} container - Address container
		 * @param {boolean}     show      - Whether to show state
		 */
		toggleStateVisibility( container, show ) {
			if ( ! container ) {
				return;
			}
			container.classList.toggle( 'address-fields-visible', show );
		},

		/**
		 * Fetch states via AJAX.
		 * @param {string}      country - Country code
		 * @param {HTMLElement} stateEl - State element
		 */
		fetchStates( country, stateEl ) {
			const placeholder = country === 'CA' ? 'province' : 'state';
			stateEl.innerHTML = `<option value="">Loading ${ placeholder }...</option>`;

			fetch( GFDynamicCountryState.ajaxUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: new URLSearchParams( {
					action: 'get_states_by_country',
					country,
					nonce: GFDynamicCountryState.nonce,
				} ),
			} )
				.then( ( response ) => response.json() )
				.then( ( data ) => {
					stateEl.value = -1;

					if ( data.success && data.data ) {
						GFDynamicCountryState.countries[ country ].states = data.data;
					}

					if ( data.success && data.data && Object.keys( data.data ).length > 0 ) {
						this.populateStates( country, stateEl, data.data, '' );
					} else {
						stateEl.innerHTML = '<option value="">No states available</option>';
					}
				} )
				.catch( () => {
					stateEl.innerHTML = '<option value="">Error loading states/province</option>';
				} );
		},

		/**
		 * Populate states in dropdown.
		 * @param {HTMLElement} countryCode  - Country code
		 * @param {HTMLElement} stateEl      - State element
		 * @param {Object}      states       - States data
		 * @param {string}      currentState - Current value
		 */
		populateStates( countryCode, stateEl, states, currentState ) {
			const placeholder = countryCode === 'CA' ? 'Select a province' : 'Select a state';
			stateEl.innerHTML = `<option value="">${ placeholder }</option>`;

			// Sort states by name.
			const statesArray = Object.entries( states )
				.map( ( [ code, name ] ) => ( { code, name } ) )
				.sort( ( a, b ) => a.name.localeCompare( b.name ) );

			// Add sorted state options.
			statesArray.forEach( ( state ) => {
				const option = document.createElement( 'option' );
				option.value = state.name;
				option.textContent = state.name;
				option.selected = ( state.name === currentState );
				stateEl.appendChild( option );
			} );

			// Trigger change event.
			stateEl.dispatchEvent( new Event( 'change' ) );
		},
	};

	// Initialize on document ready.
	document.addEventListener( 'DOMContentLoaded', () => DynamicCountryState.init() );
}() );
