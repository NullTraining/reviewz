@user
Feature:
  As a user
  In order to attend events
  I need to join organization

  Background:
    Given there is a "Local meetup" organization

  Scenario: User can join organization
    Given I'am logged in as "Jo Johnson"
    When I join "Local meetup" organization
    Then I should be a member of "Local meetup" organization
