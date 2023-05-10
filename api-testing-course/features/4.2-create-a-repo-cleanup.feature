Feature: Delete a repository

  Scenario: I want to delete a repository
    Given I am an authenticated user
    And I request a list of my repositories
    And the results should include a repository named "something-cool"
    When I delete a repository called "something-cool"
    And I request a list of my repositories
    Then the results should not include a repository named "something-cool"