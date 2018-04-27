@event
Feature:
  As a member
  In order to tell if I'm attending an event
  I need to RSVP

  Background:
    Given there is a "Local meetup" organization
    And "March 2019 gathering" is scheduled for "2019-03-07"
    And "Jo Johnson" is a member of "Local meetup" organization

  Scenario: Member can RSVP Yes to an event
    Given I'am logged in as "Jo Johnson"
    When I RSVP Yes to "March 2019 gathering"
    Then I will be on a list of interested members for "March 2019 gathering" event

  Scenario: Member can RSVP No to an event
    Given I'am logged in as "Jo Johnson"
    When I RSVP No to "March 2019 gathering"
    Then I will be on a list of members not coming to "March 2019 gathering" event
