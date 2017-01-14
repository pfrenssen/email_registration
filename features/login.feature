@api
Feature: User login
  In order to use personalized features of the site
  As a user
  I want to log in using my credentials

  Scenario: Log in through the UI with e-mail address and password
    Given users:
    | name | pass       | mail               |
    | Mort | Ysabell123 | mort@sto-helit.org |
    When I visit "user"
    Then I should see the text "Log in"
    And I should see the text "Reset your password"
    And I should see the text "E-mail"
    And I should see the text "Password"
    But I should not see the text "Log out"
    And I should not see the text "My account"
    And I should not see the text "Username"

    When I fill in the following:
    | E-mail   | mort@sto-helit.org |
    | Password | Ysabell123         |
    And I press "Log in"
    Then I should see the text "My account"

  Scenario: Log in using the provided step definition
    When I am logged in as a user with the authenticated role
    Then I should see the text "My account"
