@event
Feature:
  As a organizer
  I can create event

  Background:
    Given there is Organization "My organization"

  Scenario: Organizer can create event
    Given I'am organizer
    When I create "Some event" event for organization "My organization" with date "2018-04-24", description "Event description" in "Katran klub" location
    Then there is new "Some event" for organization "My organization"
