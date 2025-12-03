Feature: Search Functionality
  As a website visitor
  I want to search for content
  So that I can find relevant information

  Background:
    Given I am on the homepage

  Scenario: Search form is visible
    When I look for the search form
    Then the search form should be visible
    And the search input field should be present

  Scenario: Perform a basic search
    When I enter "WordPress" in the search field
    And I submit the search form
    Then I should be on the search results page
    And I should see search results or a no results message

  Scenario: Search with empty query
    When I submit the search form without entering text
    Then I should remain on the current page or see a message

  Scenario: Search for special characters
    When I enter "@#$%" in the search field
    And I submit the search form
    Then the page should handle the search gracefully
    And I should not see any errors
