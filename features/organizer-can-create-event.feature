@event
Feature:
  As an Organization organizer
  I can create event

  Background:
    Given there is a 'New York Developer Ninjas' organization
    And user "Alex Smith" is organizer of "New York Developer Ninjas" organization

  Scenario: Organizer can create event
    Given I am logged in as "Alex Smith"
    When I create a new event with title "Spring Drink-up" for organization "New York Developer Ninjas" with date "2018-04-24", description "During our spring break, we'll organize drink-ups only." in venue "Bar Goto, New York, United States"
    Then the new event has title "Spring Drink-up", venue "Bar Goto, New York, United States", date "2018-04-24", description "During our spring break, we'll organize drink-ups only." and organization "New York Developer Ninjas"
