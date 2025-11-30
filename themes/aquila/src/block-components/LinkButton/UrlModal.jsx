/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
	BaseControl,
	Modal,
	TextControl,
	ToggleControl,
} from '@wordpress/components';
import { URLInput } from '@wordpress/block-editor';
import { useState, useEffect } from '@wordpress/element';

/**
 * URL Modal Component
 *
 * @param {Object}   props               Component properties.
 * @param {string}   props.className     Additional CSS class.
 * @param {Function} props.onRequestClose Callback when modal is closed.
 * @param {string}   props.title         Modal title.
 * @param {Object}   props.value         Current URL data (url, text, newWindow).
 * @param {Function} props.onChange      Callback when value changes.
 * @param {Function} props.onUrl         Optional callback when URL changes.
 *
 * @return {Element} Modal element.
 */
export function UrlModal({
	className = '',
	onRequestClose,
	title,
	value,
	onChange,
	onUrl,
}) {
	const [url, setUrl] = useState('');
	const [text, setText] = useState('');
	const [newWindow, setNewWindow] = useState(false);

	useEffect(() => {
		if (value && Object.keys(value).length > 0) {
			setUrl(value.url || '');
			setText(value.text || '');
			setNewWindow(value.newWindow || false);
		}
	}, [value]);

	return (
		<Modal
			title={title}
			shouldCloseOnClickOutside={false}
			className={className}
			onRequestClose={onRequestClose}
		>
			<BaseControl
				label={__('URL', 'aquila')}
				className="aquila-url-control"
				id="aquila-url-input"
			>
				<URLInput
					value={url}
					onChange={(newUrl, post) => {
						if (onUrl) {
							onUrl(newUrl, post);
						}

						let changes = {
							url: newUrl,
							text,
							newWindow,
						};

						if (post && '' === text) {
							changes.text = post.title;
						} else if ('' === newUrl) {
							changes.text = '';
							changes.newWindow = false;
						}

						setUrl(changes.url);
						onChange(changes);
					}}
				/>
			</BaseControl>
			<TextControl
				label={__('Link Text', 'aquila')}
				value={text}
				onChange={(newText) => {
					setText(newText);
					onChange({ url, text: newText, newWindow });
				}}
			/>
			<ToggleControl
				label={__('New Tab', 'aquila')}
				help={__('Open link in a new tab?', 'aquila')}
				checked={newWindow}
				onChange={() => onChange({ url, text, newWindow: !newWindow })}
			/>
		</Modal>
	);
}
