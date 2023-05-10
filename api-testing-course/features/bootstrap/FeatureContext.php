<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    protected $monkeyCount = 0;

    protected $client = null;
    protected $results = null;
    protected $params = null;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(array $parameters = [])
    {
        $this->params = $parameters;
        $this->client = new \Github\Client();
    }


    /**
     * @Given I am an anonymous user
     */
    public function iAmAnAnonymousUser()
    {
       // don't do anything here. We're anonymous by default
    }

    /**
     * @When I request a list of issues for the Symfony repository from user Symfony
     */
    public function iRequestAListOfIssuesForTheSymfonyRepositoryFromUserSymfony()
    {
        $issues = $this->client->issues()->all('Symfony', 'Symfony');

        $this->results = $issues;
    }


    /**
     * @When I request the issues for the :arg1 repository from user :arg2
     */
    public function iRequestTheIssuesForTheRepositoryFromUser($arg1, $arg2)
    {
        $issues = $this->client->issues()->all($arg1, $arg2);
        
        $this->checkResponseCode(200);

        $this->results = $issues;
    }

    /**
     * @Then I should get at least :arg1 result
     */
    public function iShouldGetAtLeastResult($arg1)
    {
        if (count($this->results) < $arg1) {
            throw new Exception("Expected at least $arg1 result but got back " . count($this->results));
        }
    }

    /**
     * @Given I am an authenticated user
     */
    public function iAmAnAuthenticatedUser()
    {
        $this->client->authenticate(
            $this->params['github_token'], null, Github\AuthMethod::ACCESS_TOKEN
        );
    }

    /**
     * @When I request a list of my repositories
     */
    public function iRequestAListOfMyRepositories()
    {
        $repositories = $this->client->api('current_user')->repositories();

        $this->checkResponseCode(200);

        $this->results = $repositories;
    }

    /**
     * @Then The results should include a repository named :arg1
     */
    public function theResultsShouldIncludeARepositoryNamed($arg1)
    {
        if (!$this->repositoryExists($this->results, $arg1)) {
            throw new Exception("Expected to find a repository called '$arg1' but it doesn't exist.");
        }
    }

    /**
     * @Then the results should not include a repository named :arg1
     */
    public function theResultsShouldNotIncludeARepositoryNamed($arg1)
    {
        if ($this->repositoryExists($this->results, $arg1)) {
            throw new Exception("Expected not to find a repository called '$arg1' but it does exist.");
        }
    }

    protected function repositoryExists($repoArray, $repoName)
    {
        $repositories = array_column($repoArray, 'name', 'name');

        return isset($repositories[$repoName]);
    }

    /**
     * @When I star my :arg1 repository
     */
    public function iStarMyRepository($arg1)
    {
        $githubUser = $this->client->api('current_user')->show()['login'];
        $this->client->api('current_user')->starring()->star($githubUser, $arg1);
    }

    /**
     * @When I unstar my :arg1 repository
     */
    public function iUnstarMyRepository($arg1)
    {
        $githubUser = $this->client->api('current_user')->show()['login'];
        $this->client->api('current_user')->starring()->unstar($githubUser, $arg1);
    }

    /**
     * @Then my :arg1 repository will list me as a stargazer
     */
    public function myRepositoryWillListMeAsAStargazer($arg1)
    {
        $githubUser = $this->client->api('current_user')->show()['login'];
        if (!$this->isAStargazer($githubUser, $arg1)) {
            throw new Exception("Expected current user to be a stargazer of the '$githubUser/$arg1' repository but they were not.");
        }
    }

    /**
     * @Then my :arg1 repository will not list me as a stargazer
     */
    public function myRepositoryWillNotListMeAsAStargazer($arg1)
    {
        $githubUser = $this->client->api('current_user')->show()['login'];
        if ($this->isAStargazer($githubUser, $arg1)) {
            throw new Exception("Expected current user to not be a stargazer of the '$githubUser/$arg1' repository but they were.");
        }
    }

    /**
     *  Simplified this function to determine if the user is currently a stargazer for a repo.
    */
    protected function isAStargazer($user, $repo)
    {
        $_stargazers = $this->client->api('repo')->stargazers()->all($user, $repo);
        $stargazers = array_column($_stargazers, 'login', 'login');

        return isset($stargazers[$user]);
    }

    /**
     * @When I create a repository called :arg1
     */
    public function iCreateARepositoryCalled($arg1)
    {
        $this->client->api('repo')->create($arg1, 
            'This is the repo description', 'http://google.com', true);

        $this->checkResponseCode(201);
    }

    /**
     * @Then I delete a repository called :arg1
     */
    public function iDeleteARepositoryCalled($arg1)
    {
        $githubUser = $this->client->api('current_user')->show()['login'];
        $this->client->api('repo')->remove($githubUser, $arg1);
        
        $this->checkResponseCode(204);
    }

    protected function checkResponseCode($expected)
    {
        $statusCode   = $this->client->getLastResponse()->getStatusCode();

        if ($expected != $statusCode) {
            throw new Exception("Expected a $expected status code but got $statusCode instead!");
        }
    }


    /**
     * @Given I have :arg1 monkeys
     */
    public function iHaveMonkeys($arg1)
    {
        $this->monkeyCount = (int) $arg1;
    }

    /**
     * @When I get :arg1 more monkeys
     */
    public function iGetMoreMonkeys($arg1)
    {
        $this->monkeyCount += (int) $arg1;
    }

    /**
     * @Then I should have :arg1 monkeys
     */
    public function iShouldHaveMonkeys($arg1)
    {
        assert($this->monkeyCount == $arg1, "We expected $arg1 monkeys but found " . $this->monkeyCount);
    }
}
