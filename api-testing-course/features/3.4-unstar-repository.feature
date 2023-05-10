Feature: Unstar a repository

  Scenario: I want to unstar an important repository
    Given I am an authenticated user
    When I unstar my "is-your-api-misbehaving" repository
    Then my "is-your-api-misbehaving" repository will not list me as a stargazer