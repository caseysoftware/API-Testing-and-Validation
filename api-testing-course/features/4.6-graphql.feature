Feature: Get my list of repositories via the GraphQL endpoint

  Scenario: I want to find my private repository
    Given I am an authenticated user
    When I use the GraphQL endpoint to request a list of my repositories
    Then the results should include a repository named "is-your-api-misbehaving"