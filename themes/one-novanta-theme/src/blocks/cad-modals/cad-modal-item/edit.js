/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { link as linkIcon } from '@wordpress/icons';
import { useRef } from '@wordpress/element';
import {
	BlockControls, RichText, useBlockProps,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis -- Reason WP internally uses LinkControl in paragraph and other blocks.
	__experimentalLinkControl as LinkControl,
} from '@wordpress/block-editor';
import { ToolbarButton, ToolbarGroup, Popover } from '@wordpress/components';

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object} props               Block Props.
 * @param {Object} props.attributes    Block Attributes.
 * @param {Object} props.setAttributes Block Attributes setter method.
 * @param {Object} props.clientId      A unique identifier assigned to each block instance.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit( { attributes, setAttributes, clientId } ) {
	// Show LinkControl near card.
	const cardRef = useRef();

	const baseClass = 'wp-one-novanta-table';

	// Get the block props with custom class names.
	const blockProps = useBlockProps( {
		className: baseClass + '__body-row',
	} );

	// Show already stored linkMeta or make link meta from URL for migrated data.
	const dataURL = attributes.linkMeta.length ? attributes.linkMeta : { url: attributes.url };

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						icon={ linkIcon }
						onClick={ () =>
							setAttributes( {
								showURLInput: ! attributes.showURLInput,
							} )
						}
						label={ __( 'Add Link for the Tile', 'one-novanta-theme' ) }
					/>
				</ToolbarGroup>
			</BlockControls>
			{ attributes.showURLInput && (
				<Popover
					position="bottom right"
					onClose={ () => setAttributes( { showURLInput: false } ) }
					anchor={ cardRef.current }
				>
					<LinkControl
						settings={ [] }
						value={ dataURL }
						key={ `image-tile-link-${ clientId }` }
						onRemove={ () =>
							setAttributes( { linkMeta: {}, url: '' } )
						}
						onChange={ ( newLinkMeta ) =>
							setAttributes( {
								linkMeta: newLinkMeta,
								url: newLinkMeta?.url ?? '',
							} )
						}
					/>
				</Popover>
			) }
			<tr { ...blockProps } >
				<RichText
					tagName="td"
					value={ attributes.label }
					onChange={ ( label ) =>
						setAttributes( { label } )
					}
					placeholder={ __( 'Set Download item', 'one-novanta-theme' ) }
					className={ `${ baseClass }__body-cell ${ attributes.url.length ? baseClass + '__body_cell-link' : '' }` }
					allowedFormats={ [] }
					ref={ cardRef }
				/>
				<RichText
					tagName="td"
					value={ attributes.description }
					onChange={ ( description ) =>
						setAttributes( { description } )
					}
					placeholder={ __( 'Set Description', 'one-novanta-theme' ) }
					className={ `${ baseClass }__body-cell` }
					allowedFormats={ [] }
				/>
			</tr>
		</>
	);
}
