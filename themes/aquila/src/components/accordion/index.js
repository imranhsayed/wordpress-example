import './style.scss';

document.addEventListener('DOMContentLoaded', () => {
	const accordions = document.querySelectorAll('.accordion');

	accordions.forEach((accordion) => {
		const triggers = accordion.querySelectorAll('.accordion__trigger');

		triggers.forEach((trigger) => {
			trigger.addEventListener('click', () => {
				const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
				const panelId = trigger.getAttribute('aria-controls');
				const panel = document.getElementById(panelId);

				// Close all triggers and panels in this accordion
				triggers.forEach((otherTrigger) => {
					const otherPanelId = otherTrigger.getAttribute('aria-controls');
					const otherPanel = document.getElementById(otherPanelId);

					otherTrigger.setAttribute('aria-expanded', 'false');
					if (otherPanel) {
						otherPanel.setAttribute('hidden', '');
					}
				});

				// Open the clicked one if it wasn't already open
				if (!isExpanded && panel) {
					trigger.setAttribute('aria-expanded', 'true');
					panel.removeAttribute('hidden');
				}
			});
		});
	});
});
