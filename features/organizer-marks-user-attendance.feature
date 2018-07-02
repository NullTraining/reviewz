@event
Feature:
  As an organizer
  In order to track event attendance
  I need to mark member as attended during meetup

  Background:
    Given there is a "New York Developer Ninjas" organization
    And user "Alex Smith" is organizer of "New York Developer Ninjas" organization
    And "March 2019 gathering" is scheduled for "2019-03-07"
    And user "Jo Johnson" RSVPed Yes to event "March 2019 gathering"

  Scenario: Organizers have expected attendance list
    Given I am logged in as "Alex Smith"
    When I look at expected attendees list for "March 2019 gathering" event
    Then I should see user "Jo Johnson" in the expected attendees list

  Scenario: Mark member as attended
    Given I am logged in as "Alex Smith"
    When I mark user "Jo Johnson" as attended "March 2019 gathering" event
    Then user "Jo Johnson" is marked as attended "March 2019 gathering" event

  Scenario: Marked member will not show in expected attendance list
    Given I am logged in as "Alex Smith"
    When I mark user "Jo Johnson" as attended "March 2019 gathering" event
    Then user "Jo Johnson" is marked as attended "March 2019 gathering" event

  Scenario: Confirm Event Attendance for Users who came to the Event, but have RSVPed No
    Given I am logged in as "Alex Smith"
    And user "Jo Johnson" RSVPed No to event "March 2019 gathering"
    And I mark user "Jo Johnson" as attended "March 2019 gathering" event
    Then user "Jo Johnson" is marked as attended "March 2019 gathering" event
