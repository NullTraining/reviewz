@organization
Feature:
  As an organizer
  I can promote other members to organizers

  Background:
    Given there is a "New York Developer Ninjas" organization created by "Alex Smith"

  Scenario: Organizer can promote members to organizers
    Given I am logged in as "Alex Smith"
    And "Jo Johnson" is member of "New York Developer Ninjas" organization
    When I promote "Jo Johnson" to organizer of "New York Developer Ninjas"
    Then "Jo Johnson" is organizer of "New York Developer Ninjas"

  Scenario: Existing organizers cant be promoted to organizers
    Given I am logged in as "Alex Smith"
    When I promote "Alex Smith" to organizer of "New York Developer Ninjas"
    Then I will get an error saying that user is already an organizer

  Scenario: In order to promote user, they have to be a member of organization
    Given I am logged in as "Alex Smith"
    When I promote "Jo Johnson" to organizer of "New York Developer Ninjas"
    Then I will get an error saying that user needs to be a member in order to be promoted
