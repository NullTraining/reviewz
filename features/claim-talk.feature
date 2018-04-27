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

  Scenario: Talks with pending claims can not be claimed
    Given "Something about nothing" has a pending claim by "Jo Johnson"
    And I'am logged in as "Alex Smith"
    When I claim "Something about nothing"
    Then I should see an error saying there is a pending claim on the talk

  Scenario: Talks with rejected claims can be claimed
    Given "Something about nothing" has a rejected claim by "Jo Johnson"
    And I'am logged in as "Alex Smith"
    When I claim "Something about nothing"
    Then I should have "Something about nothing" claimed
