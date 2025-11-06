/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { InnerBlocks, useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of a block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {JSX.Element} Element to render.
 */
export default function Edit() {
	const baseClass = 'wp-one-novanta-table';

	// Get the block props with custom class names.
	const blockProps = useBlockProps( {
		className: `${ baseClass } alignwide ${ baseClass }--has-background--secondary`,
	} );

	// Directly get props for the <tbody> without blockProps
	const tbodyProps = useInnerBlocksProps(
		{
			className: `${ baseClass }__body`, // this becomes the class on <tbody>
		},
		{
			allowedBlocks: [ 'one-novanta/cad-modal-item' ],
			template: [ [ 'one-novanta/cad-modal-item' ] ],
			renderAppender: false,
			templateLock: false,
		},
	);

	return (
		<div { ...blockProps } >
			<figure>
				<table className={ `${ baseClass }__wrapper` }>
					<thead className={ `${ baseClass }__head` }>
						<tr className={ `${ baseClass }__head-row` }>
							<th className={ `${ baseClass }__head-cell ${ baseClass }__head-cell__background-mid-gray` }>
								{ __( 'Download', 'one-novanta-theme' ) }
							</th>
							<th className={ `${ baseClass }__head-cell ${ baseClass }__head-cell__background-mid-gray` }>
								{ __( 'Description', 'one-novanta-theme' ) }
							</th>
						</tr>
					</thead>

					<tbody { ...tbodyProps } />

					<tfoot>
						<tr>
							<td colSpan="3">
								<InnerBlocks.ButtonBlockAppender />
							</td>
						</tr>
					</tfoot>
				</table>
			</figure>
		</div>
	);
}
