Feature: Verify Contact Form Submission

	Feature Description

	Verify the user is able to fill and successfully submit the Form

	Scenario: Verify Successful Form Submission
		Given I navigate to the page "https://rishav.rt.gw/contact-us-page/"
		When I enter the First name "Rishav"
		When I enter the last name "Dutta"
		When I enter the email "rishav.dutta2024@gmail.com"
		When I enter the confirm email "rishav.dutta2024@gmail.com"
		When I enter the comments "Test Comment"
		When I click on the submit button
		Then The form should be successfully submitted