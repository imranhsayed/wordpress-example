/**
 * Design Tokens Component
 *
 * This component displays all design system tokens
 */

import './index.scss';

// Copy to clipboard functionality
document.addEventListener('DOMContentLoaded', function() {
	const copyButtons = document.querySelectorAll('.design-tokens__copy-btn');

	copyButtons.forEach(button => {
		// Add copy message element dynamically if it doesn't exist
		let messageElement = button.nextElementSibling;
		if (!messageElement || !messageElement.classList.contains('design-tokens__copy-message')) {
			messageElement = document.createElement('span');
			messageElement.className = 'design-tokens__copy-message';
			messageElement.textContent = 'Copied to clipboard';
			button.parentNode.appendChild(messageElement);
		}

		button.addEventListener('click', function() {
			const textToCopy = this.getAttribute('data-copy');

			// Use the Clipboard API
			if (navigator.clipboard && navigator.clipboard.writeText) {
				navigator.clipboard.writeText(textToCopy).then(() => {
					showCopiedState(this, messageElement);
				}).catch(err => {
					console.error('Failed to copy:', err);
					fallbackCopy(textToCopy, this, messageElement);
				});
			} else {
				// Fallback for older browsers
				fallbackCopy(textToCopy, this, messageElement);
			}
		});
	});

	function showCopiedState(button, messageElement) {
		// Add copied class for visual feedback
		button.classList.add('copied');

		// Show the message
		messageElement.classList.add('show');

		// Remove the message after 300ms and button state after 2 seconds
		setTimeout(() => {
			messageElement.classList.remove('show');
		}, 300);

		setTimeout(() => {
			button.classList.remove('copied');
		}, 2000);
	}

	function fallbackCopy(text, button, messageElement) {
		// Create a temporary textarea
		const textarea = document.createElement('textarea');
		textarea.value = text;
		textarea.style.position = 'fixed';
		textarea.style.opacity = '0';
		document.body.appendChild(textarea);
		textarea.select();

		try {
			document.execCommand('copy');
			showCopiedState(button, messageElement);
		} catch (err) {
			console.error('Fallback copy failed:', err);
		}

		document.body.removeChild(textarea);
	}
});
