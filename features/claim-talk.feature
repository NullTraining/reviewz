@talk
Feature:
  As a user
  In order to connect me to a talk
  I need to claim a talk

  Background:
    Given there is a "New York Developer Ninjas" organization
    And "March 2019 gathering" is scheduled for "2019-03-07"
    And there is a talk "Joys of Programming"

  Scenario: Speaker can claim unclaimed talk
    Given I am logged in as "Jo Johnson"
    When I claim "Joys of Programming"
    Then I should have "Joys of Programming" claimed

  Scenario: Talks with pending claims can not be claimed
    Given "Joys of Programming" has a pending claim by "Jo Johnson"
    And I am logged in as "Alex Smith"
    When I claim "Joys of Programming"
    Then I should see an error saying there is a pending claim on the talk

  Scenario: Talks with rejected claims can be claimed
    Given "Joys of Programming" has a rejected claim by "Jo Johnson"
    And I am logged in as "Alex Smith"
    When I claim "Joys of Programming"
    Then I should have "Joys of Programming" claimed

  Scenario: Talks with speaker assigned can not be claimed
    Given "Joys of Programming" has "Jo Johnson" assigned as speaker
    And I am logged in as "Alex Smith"
    When I claim "Joys of Programming"
    Then I should see an error saying there speaker is already assigned
