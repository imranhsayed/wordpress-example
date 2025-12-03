Feature: Homepage Navigation
  As a website visitor
  I want to navigate the homepage
  So that I can access different sections of the website

  Background:
    Given I am on the homepage

  Scenario: View homepage title
    Then the page title should be visible
    And the page should have a valid title

  Scenario: Check main navigation exists
    Then I should see the main navigation menu
    And the navigation should contain links

  Scenario: View page content
    Then I should see the main content area
    And the content should not be empty

  Scenario: Check page footer
    Then I should see the footer section
    And the footer should contain copyright information
