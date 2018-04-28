@event
Feature:
  As an Organization organizer
  I can create event

  Background:
    Given there is a 'Local organization' organization
    And user "Jo Johnson" is organizer of "Local organization" organization

  Scenario: Organizer can create event
    Given I'am logged in as "Jo Johnson"
    When I create a new event with name "Some event" for organization "Local organization" with date "2018-04-24", description "Event description" in venue "Katran klub"
    Then There is a new event with name "Some event" and venue "Katran klub" for organization "Local organization"
