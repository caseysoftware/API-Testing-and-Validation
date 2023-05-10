Feature: Star a repository

  Scenario: I want to star an important repository
    Given I am an authenticated user
    When I star my "is-your-api-misbehaving" repository
    Then my "is-your-api-misbehaving" repository will list me as a stargazer