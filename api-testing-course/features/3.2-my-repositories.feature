Feature: Get my list of repositories

  Scenario: I want to find my private repository
    Given I am an authenticated user
    When I request a list of my repositories
    Then the results should include a repository named "is-your-api-misbehaving"