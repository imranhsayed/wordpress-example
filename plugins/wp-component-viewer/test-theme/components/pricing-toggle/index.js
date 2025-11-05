/**
 * Pricing Toggle Component JavaScript
 * 
 * Handles the toggle functionality for pricing period switching
 * and dispatches custom events for other components to listen to
 */
import './index.scss'; // Import styles for the toggle

/**
 * Pricing Toggle Component JavaScript
 * 
 * Simple toggle functionality for pricing period switching (no forms)
 */

// Initialize pricing toggle functionality
function initPricingToggle() {
	const toggles = document.querySelectorAll('.pricing-toggle');
	
	if (toggles.length === 0) return;

	toggles.forEach(function(toggle) {
		setupPricingToggle(toggle);
	});
}

// Setup individual toggle
function setupPricingToggle(toggle) {
	const options = toggle.querySelectorAll('.pricing-toggle__option');
	const slider = toggle.querySelector('.pricing-toggle__slider');
	
	if (!options.length || !slider) return;

	// Add click event to option buttons
	options.forEach(function(option) {
		option.addEventListener('click', function() {
			handlePricingToggle(option, toggle, slider, options);
		});

		// Handle keyboard navigation
		option.addEventListener('keydown', function(e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				handlePricingToggle(option, toggle, slider, options);
			}
		});
	});
}

// Handle toggle change
function handlePricingToggle(clickedOption, toggle, slider, allOptions) {
	const selectedPeriod = clickedOption.getAttribute('data-period');
	const isYearly = selectedPeriod === 'yearly';
	
	// Update active states
	allOptions.forEach(function(option) {
		option.classList.remove('pricing-toggle__option--active');
		option.setAttribute('aria-pressed', 'false');
	});
	
	// Set clicked option as active
	clickedOption.classList.add('pricing-toggle__option--active');
	clickedOption.setAttribute('aria-pressed', 'true');
	
	// Update slider position
	if (isYearly) {
		slider.classList.add('pricing-toggle__slider--yearly');
	} else {
		slider.classList.remove('pricing-toggle__slider--yearly');
	}
	
	// Store current selection in toggle element
	toggle.setAttribute('data-current-period', selectedPeriod);
	
	// Trigger custom event for other components
	const event = new CustomEvent('pricingChanged', {
		detail: {
			period: selectedPeriod,
			isYearly: isYearly,
			toggle: toggle
		},
		bubbles: true
	});
	
	document.dispatchEvent(event);
	
	// Console log for debugging
	console.log('Pricing period changed to:', selectedPeriod);
}

// Get current period of a toggle
function getCurrentPeriod(toggle) {
	if (!toggle) {
		toggle = document.querySelector('.pricing-toggle');
	}
	
	if (!toggle) return null;
	
	return toggle.getAttribute('data-current-period') || 'monthly';
}

// Set period programmatically
function setPricingPeriod(period, toggle) {
	if (!toggle) {
		toggle = document.querySelector('.pricing-toggle');
	}
	
	if (!toggle) return false;
	
	const option = toggle.querySelector(`[data-period="${period}"]`);
	if (option) {
		const slider = toggle.querySelector('.pricing-toggle__slider');
		const allOptions = toggle.querySelectorAll('.pricing-toggle__option');
		handlePricingToggle(option, toggle, slider, allOptions);
		return true;
	}
	
	return false;
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
	initPricingToggle();
});

// Listen for pricing changes (example for other components)
document.addEventListener('pricingChanged', function(e) {
	// Update pricing cards or other elements
	const pricingCards = document.querySelectorAll('.pricing-card');
	
	pricingCards.forEach(function(card) {
		if (e.detail.isYearly) {
			card.classList.add('pricing-yearly');
			card.classList.remove('pricing-monthly');
		} else {
			card.classList.add('pricing-monthly');
			card.classList.remove('pricing-yearly');
		}
	});
	
	// Update any price displays
	const priceElements = document.querySelectorAll('[data-monthly-price], [data-yearly-price]');
	priceElements.forEach(function(element) {
		const monthlyPrice = element.getAttribute('data-monthly-price');
		const yearlyPrice = element.getAttribute('data-yearly-price');
		
		if (e.detail.isYearly && yearlyPrice) {
			element.textContent = yearlyPrice;
		} else if (!e.detail.isYearly && monthlyPrice) {
			element.textContent = monthlyPrice;
		}
	});
});