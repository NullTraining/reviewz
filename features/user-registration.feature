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
      | country   | USA                    |
      | city      | New York               |
    Then I have created an account
