import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function Edit({ attributes, setAttributes }) {
	const { content } = attributes;
	
	const blockProps = useBlockProps({
		className: 'novanta-notice',
	});
	
	return (
		<>
			<div {...blockProps}>
				<RichText
					tagName="p"
					placeholder={__('Add your content here', 'aquila-theme')}
					value={content}
					onChange={(value) => setAttributes({ content: value })}
					keepPlaceholderOnFocus
					className="novanta-notice__content"
					allowedFormats={['core/bold', 'core/link']}
				/>
			</div>
		</>
	);
}
