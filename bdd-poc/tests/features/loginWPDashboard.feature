Feature: Login to WP Dashboard

  Scenario: Successful login with valid credentials
	Given I am on the WordPress login page
	When I enter a valid username and password
	Then I should see a welcome message