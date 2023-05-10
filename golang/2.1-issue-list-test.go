package main

import (
  // "context"
  // "fmt"
  // "testing"

  "github.com/cucumber/godog"
)

func iAmAnAnonymousUser() error {
	return godog.ErrPending
}

func iRequestAListOfIssuesForTheSymfonyRepositoryFromUserSymfony() error {
	return godog.ErrPending
}

func iShouldGetAtLeastResult(arg1 int) error {
	return godog.ErrPending
}

func InitializeScenario(ctx *godog.ScenarioContext) {
	ctx.Step(`^I am an anonymous user$`, iAmAnAnonymousUser)
	ctx.Step(`^I request a list of issues for the Symfony repository from user Symfony$`, iRequestAListOfIssuesForTheSymfonyRepositoryFromUserSymfony)
	ctx.Step(`^I should get at least (\d+) result$`, iShouldGetAtLeastResult)
}
