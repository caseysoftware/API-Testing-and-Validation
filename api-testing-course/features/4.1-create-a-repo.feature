Feature: Create a repository

  Scenario: I want to create a repository
    Given I am an authenticated user
    When I create a repository called "something-cool"
    And I request a list of my repositories
    Then the results should include a repository named "something-cool"