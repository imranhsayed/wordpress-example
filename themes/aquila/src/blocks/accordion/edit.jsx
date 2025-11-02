/**
 * WordPress dependencies
 */
import {
	useBlockProps,
	InnerBlocks,
} from '@wordpress/block-editor';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	// Block props.
	const blockProps = useBlockProps();

	return (
		<>
			<div { ...blockProps }>
				<InnerBlocks
					template={ [ [ 'aquila/accordion-item' ] ] }
					allowedBlocks={ [ 'aquila/accordion-item' ] }
					templateLock={ false }
					renderAppender={
						() => <InnerBlocks.ButtonBlockAppender />
					}
				/>
			</div>
		</>
	);
}
