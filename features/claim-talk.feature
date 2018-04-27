@talk
Feature:
  As a user
  In order to connect me to a talk
  I need to claim a talk

  Background:
    Given there is a "Local meetup" organization
    And "March 2019 gathering" is scheduled for "2019-03-07"
    And there is a talk "Something about nothing"

  Scenario: Speaker can claim unclaimed talk
    Given I'am logged in as "Jo Johnson"
    When I claim "Something about nothing"
    Then I should have "Something about nothing" claimed
