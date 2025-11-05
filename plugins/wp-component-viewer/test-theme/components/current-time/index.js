/**
 * Component: Current Time
 * Auto-updates elements with `.current-time-component` using data-time-format attribute.
 */

import './index.scss';

(() => {
	const pad = (n) => (n < 10 ? '0' + n : n);

	function formatTime(date, format) {
		let hours24 = date.getHours();
		let hours12 = hours24 % 12 || 12;
		let minutes = pad(date.getMinutes());
		let seconds = pad(date.getSeconds());
		let ampm = hours24 >= 12 ? 'PM' : 'AM';

		return format
			.replace(/H/, pad(hours24))
			.replace(/h/, pad(hours12))
			.replace(/i/, minutes)
			.replace(/s/, seconds)
			.replace(/A/, ampm);
	}

	function updateClocks() {
		const now = new Date();

		document.querySelectorAll('.current-time-component').forEach((el) => {
			const format = el.dataset.timeFormat || 'H:i:s';
			const clock = el.querySelector('.current-time-component__clock');
			if (clock) {
				clock.textContent = formatTime(now, format);
			}
		});
	}

	setInterval(updateClocks, 1000);
	updateClocks(); // Initial run
})();
