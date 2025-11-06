/**
 * WordPress dependencies
 */
import {
	BlockControls,
	InnerBlocks,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	ToolbarButton,
	ToolbarGroup,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useEffect } from '@wordpress/element';

/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import TEMPLATE from './template';
import MediaControls from '../../js/block-components/media-controls';
import MediaPreview from '../../js/block-components/media-preview';

export default function Edit( { attributes, setAttributes, context } ) {
	const {
		imageID,
		imageURL,
		imageAlt,
		mediaAlign,
		backgroundColor,
	} = attributes;

	const blockProps = useBlockProps( {
		className: classnames( [
			'media-text',
			'alignwide',
			`media-text--media-align-${ mediaAlign }`,
		], {
			[ `has-${ backgroundColor }-background-color` ]: backgroundColor,
		} ),
	} );

	useEffect( () => {
		if ( context.backgroundColor ) {
			if ( 'background' === context.backgroundColor ) {
				setAttributes( { backgroundColor: 'secondary' } );
			}

			if ( 'secondary' === context.backgroundColor ) {
				setAttributes( { backgroundColor: 'background' } );
			}
		} else {
			setAttributes( { backgroundColor: 'secondary' } );
		}
	}, [ context, setAttributes ] );

	const onSelectMedia = ( media ) => {
		setAttributes( {
			imageID: media?.id || 0,
			imageURL: media?.url || '',
			imageAlt: media?.alt || '',
		} );
	};

	return (
		<>
			<BlockControls>
				<ToolbarGroup>
					<ToolbarButton
						label={ __( 'Align Media Left', 'one-novanta-theme' ) }
						icon="align-pull-left"
						isPressed={ mediaAlign === 'left' }
						onClick={ () => setAttributes( { mediaAlign: 'left' } ) }
					/>
					<ToolbarButton
						label={ __( 'Align Media Right', 'one-novanta-theme' ) }
						icon="align-pull-right"
						isPressed={ mediaAlign === 'right' }
						onClick={ () => setAttributes( { mediaAlign: 'right' } ) }
					/>
				</ToolbarGroup>
				<MediaControls
					imageID={ imageID }
					imageURL={ imageURL }
					onSelectMedia={ onSelectMedia }
					onResetMedia={ () => onSelectMedia( undefined ) }
				/>
			</BlockControls>

			<div { ...blockProps }>
				<MediaPreview
					url={ imageURL }
					onSelect={ onSelectMedia }
					imgAlt={ imageAlt || __( 'Media & Text image', 'one-novanta-theme' ) }
					placeholderTitle={ __( 'Image', 'one-novanta-theme' ) }
					wrapperClassName="media-text__media"
				/>

				<div className="media-text__content has-medium-font-size">
					<InnerBlocks
						template={ TEMPLATE }
						allowedBlocks={ [ 'core/paragraph', 'core/list', 'core/buttons', 'core/heading' ] }
						templateLock={ false }
					/>
				</div>
			</div>

		</>
	);
}
