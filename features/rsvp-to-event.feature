@event
Feature:
  As a member
  In order to tell if I'm attending an event
  I need to RSVP

  Background:
    Given there is a "New York Developer Ninjas" organization
    And "March 2019 gathering" is scheduled for "2019-03-07"
    And "Jo Johnson" is a member of "New York Developer Ninjas" organization

  Scenario: Member can RSVP Yes to an event
    Given I am logged in as "Jo Johnson"
    When I RSVP Yes to "March 2019 gathering"
    Then I will be on a list of interested members for "March 2019 gathering" event

  Scenario: Member can RSVP No to an event
    Given I am logged in as "Jo Johnson"
    When I RSVP No to "March 2019 gathering"
    Then I will be on a list of members not coming to "March 2019 gathering" event

  Scenario: Member can change RSVP from No to Yes
    Given I am logged in as "Jo Johnson"
    And I have RSVPed No to "March 2019 gathering" event
    When I change my "March 2019 gathering" RSVP to Yes
    Then I will be on a list of interested members for "March 2019 gathering" event
    And I will not be on a list of members not coming to "March 2019 gathering" event

  Scenario: Member can change RSVP from Yes to No
    Given I am logged in as "Jo Johnson"
    And I have RSVPed Yes to "March 2019 gathering" event
    When I change my "March 2019 gathering" RSVP to No
    Then I will be on a list of members not coming to "March 2019 gathering" event
    And I will not be on a list of interested members for "March 2019 gathering" event

