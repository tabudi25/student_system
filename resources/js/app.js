import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
	const toggleButton = document.querySelector('[data-nav-toggle]');
	const navPanel = document.querySelector('[data-nav-panel]');

	if (!toggleButton || !navPanel) {
		return;
	}

	const setExpanded = (isExpanded) => {
		toggleButton.setAttribute('aria-expanded', String(isExpanded));
		navPanel.classList.toggle('hidden', !isExpanded);
		navPanel.classList.toggle('flex', isExpanded);
	};

	setExpanded(false);

	toggleButton.addEventListener('click', () => {
		const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
		setExpanded(!isExpanded);
	});

	navPanel.querySelectorAll('a').forEach((link) => {
		link.addEventListener('click', () => {
			if (window.matchMedia('(max-width: 767px)').matches) {
				setExpanded(false);
			}
		});
	});
});
