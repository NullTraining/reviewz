@event
Feature:
  As an Organization organizer
  I can create event

  Background:
    Given there is a 'Local organization' organization
    And user "Jo Johnson" is organizer of "Local organization" organization

  Scenario: Organizer can create event
    Given I'am logged in as "Jo Johnson"
    When I create a new event with title "Some event" for organization "Local organization" with date "2018-04-24", description "Event description" in venue "Katran klub, Zagreb, Croatia"
    Then the new event has title "Some event", venue "Katran klub, Zagreb, Croatia", date "2018-04-24", description "Event description" and organization "Local organization"
