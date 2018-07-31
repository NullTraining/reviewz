@talk
Feature:
  As an organizer
  In order to connect speakers to a talk
  I need to approve or reject claims

  Background:
    Given there is a "Local meetup" organization
    And "Alex Smith" is organizer of "Local meetup" organization
    And "March 2019 gathering" is scheduled for "2019-03-07"
    And there is a talk "Something about nothing"
    And there is a claim by "Jo Johnson" on "Something about nothing" talk

  Scenario: List of pending claims
    Given I am logged in as "Alex Smith"
    When I look at "Something about nothing" talk
    Then I should see "Jo Johnson" having a pending claim
