package main

import (
  "context"
  "fmt"
  "testing"

  "github.com/cucumber/godog"
)

// monkeysCtxKey is the key used to store the available monkesy in the context.Context.
type monkeysCtxKey struct{}

func TestFeatures(t *testing.T) {
  suite := godog.TestSuite{
    ScenarioInitializer: InitializeScenario,
    Options: &godog.Options{
      Format:   "pretty",
      Paths:    []string{"features"},
      TestingT: t, // Testing instance that will run subtests.
    },
  }

  if suite.Run() != 0 {
    t.Fatal("non-zero status returned, failed to run feature tests")
  }
}

func iHaveMonkeys(ctx context.Context, monkeys int) (context.Context, error) {
  return context.WithValue(ctx, monkeysCtxKey{}, monkeys), nil
}

func iGetMoreMonkeys(ctx context.Context, moreMonkeys int) (context.Context, error) {
  monkeys := ctx.Value(monkeysCtxKey{}).(int)

  monkeys += moreMonkeys

  return context.WithValue(ctx, monkeysCtxKey{}, monkeys), nil
}

func iShouldHaveMonkeys(ctx context.Context, totalMonkeys int) error {
  monkeys := ctx.Value(monkeysCtxKey{}).(int)

  if monkeys != totalMonkeys {
    return fmt.Errorf("expected %d monkeys, but found %d instead", totalMonkeys, monkeys)
  }

  return nil
}

func InitializeScenario(ctx *godog.ScenarioContext) {
  ctx.Step(`^I get (\d+) more monkeys$`, iGetMoreMonkeys)
  ctx.Step(`^I have (\d+) monkeys$`, iHaveMonkeys)
  ctx.Step(`^I should have (\d+) monkeys$`, iShouldHaveMonkeys)
}