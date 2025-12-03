Feature: Homepage Heartbeat

	Feature Description

	Verify the text is visible on the homepage

	Scenario: Verify Homepage Accessibility
		Given the homepage is deployed to production
		When a user navigates to the homepage
		Then the user sees "Hello, Polaris!" displayed on the page