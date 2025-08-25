Feature: Star a repository using the GraphQL endpoint

  Scenario: I want to star an important repository
    Given I am an authenticated user
    When I use the GraphQL endpoint to requstar my "is-your-api-misbehaving" repository
    Then my "is-your-api-misbehaving" repository will list me as a stargazer