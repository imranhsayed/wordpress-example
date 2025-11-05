import './index.scss';

document.addEventListener('DOMContentLoaded', function () {
	const counters = document.querySelectorAll('.impact-stats__number');
	counters.forEach(counter => {
		const updateCount = () => {
			const target = +counter.getAttribute('data-target');
			const count = +counter.innerText;
			const increment = target / 200; // animation speed

			if (count < target) {
				counter.innerText = Math.ceil(count + increment);
				requestAnimationFrame(updateCount);
			} else {
				counter.innerText = target;
			}
		};
		updateCount();
	});
});