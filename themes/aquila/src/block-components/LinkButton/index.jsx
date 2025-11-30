/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import { decodeEntities } from '@wordpress/html-entities';
import classnames from 'classnames';

/**
 * Internal dependencies
 */
import { UrlModal } from './UrlModal';

/**
 * Link Button Component
 *
 * A button component that opens a modal for configuring link properties.
 *
 * @param {Object}   props             Component properties.
 * @param {string}   props.tagName     HTML tag name for the button (default: 'button').
 * @param {Object}   props.value       Current link data (url, text, newWindow).
 * @param {string}   props.className   CSS class for the button.
 * @param {string}   props.placeholder Placeholder text when no text is set.
 * @param {string}   props.modalTitle  Title for the URL modal.
 * @param {Function} props.onChange    Callback when link data changes.
 *
 * @return {Element} LinkButton element.
 */
export default function LinkButton({
	tagName = 'button',
	value,
	className = 'wp-block-button',
	placeholder = __('Button', 'aquila'),
	modalTitle = __('URL', 'aquila'),
	onChange,
}) {
	const [modalOpen, setModalOpen] = useState(false);
	const { text } = value ?? {};
	const Tag = tagName;
	let label = placeholder;

	if (text && '' !== text) {
		label = text;
	}

	return (
		<>
			<Tag
				className={classnames(className, 'aquila-link-button')}
				onClick={() => setModalOpen(true)}
			>
				{decodeEntities(label)}
			</Tag>
			{modalOpen && (
				<UrlModal
					className="aquila-link-button__modal"
					title={modalTitle}
					onRequestClose={() => setModalOpen(false)}
					value={value || { url: '', text: '', newWindow: false }}
					onChange={(value) => onChange(value)}
				/>
			)}
		</>
	);
}
