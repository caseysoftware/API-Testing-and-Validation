
# Sample Code for LinkedIn Learning Course

This folder has all the working samples and code for the LinkedIn Learning course. To try them out, follow these instructions. They're slightly different than the README.md in the root directory.

**Note:** Other than copying the `behat.dist.yml` file. You should not have to modify any other files in this directory.

1. Ensure you have PHP installed. This course was built on PHP 8.2.x installed via Homebrew on a Mac.
2. Ensure you have [Composer](https://getcomposer.org/) installed. 
3. Download or clone this repository.
4. On your command line, move to this (the `api-testing-course`) directory.
6. Install your environment via `./composer.phar install` or equivalent depending on your Composer configuration. This will load Behat 3.12 and the Github SDK for you.
7. Copy `behat.dist.yml` to `behat.yml`
8. Create a Personal Access Token on Github via https://github.com/settings/tokens?type=beta giving it permission to
    *  User Permissions: Read and Write access to starring and watching
    *  Repository permissions: Read and Write access to administration
9. Copy and paste the Personal Access Token into `behat.yml` for the `github_token` parameter.
10. Run `vendor/bin/behat` to run these tests
