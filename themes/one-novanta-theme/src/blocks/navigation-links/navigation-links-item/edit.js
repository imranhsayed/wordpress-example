/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- LinkControl is required to set text and url for list item without selection.
import { useBlockProps, __experimentalLinkControl as LinkControl } from '@wordpress/block-editor';
import { Popover, Button, TextControl } from '@wordpress/components';
import { useState, useRef } from '@wordpress/element';

export default function Edit( { attributes, setAttributes } ) {
	const { title, url, opensInNewTab } = attributes;
	const [ isEditing, setIsEditing ] = useState( false );
	const anchorRef = useRef( null );
	const blockProps = useBlockProps( { className: `info-box__list-item` } );

	// Set attributes on text change.
	const handleChange = ( newAttrs ) => {
		setAttributes( { ...attributes, ...newAttrs } );
	};

	// Disable default propagation for link.
	const handleLink = ( e ) => {
		e.preventDefault();
		e.stopPropagation();
		setIsEditing( true );
	};

	return (
		<div { ...blockProps }>
			<div
				role="button"
				ref={ anchorRef }
				style={ { cursor: 'pointer', display: 'block' } }
				tabIndex={ 0 }
				onKeyDown={ ( e ) => {
					if ( e.key === 'Enter' || e.key === ' ' ) {
						setIsEditing( true );
					}
				} }
				onClick={ handleLink }
			>
				<a href={ url || '#' } onClick={ ( e ) => e.preventDefault() }>
					{ title }
				</a>
			</div>

			{ isEditing && (
				<Popover anchorRef={ anchorRef } onClose={ () => setIsEditing( false ) } offset={ 15 }>
					<div style={ { padding: '1.5rem' } } className={ 'navigation-links-popup-box' }>
						{ /* TextControl to set title for link */ }
						<TextControl
							label={ __( 'Link Text', 'one-novanta-theme' ) }
							value={ title }
							onChange={ ( value ) => handleChange( { title: value } ) }
						/>
						{ /* LinkControl with suggestion */ }
						<LinkControl
							value={ { url, opensInNewTab } }
							// eslint-disable-next-line no-shadow -- This is required onChange.
							onChange={ ( { url, opensInNewTab } ) => handleChange( { url, opensInNewTab } ) }
							withCreateSuggestion
						/>
						{ /* Button to close LinkControl Popup */ }
						<Button onClick={ () => setIsEditing( false ) } variant="secondary" style={ { marginTop: '1em' } }>
							{ __( 'Close', 'one-novanta-theme' ) }
						</Button>
					</div>
				</Popover>
			) }
		</div>
	);
}
