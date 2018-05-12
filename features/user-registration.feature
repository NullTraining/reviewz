@user
Feature:
  As a user
  In order to use our app
  I need to create an account

  Scenario: Registration
    When I register using
      | username  | alexsmith              |
      | firstName | Alex                   |
      | lastName  | Smith                  |
      | email     | alex.smith@example.com |
      | password  | abc123                 |
      | city      | New York,US            |
    Then I have created an account with username "alexsmith"
