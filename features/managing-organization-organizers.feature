@organization
Feature:
  As an organizer
  I can promote other members to organizers

  Background:
    Given there is a "Local organization" organization created by "Alex Smith"

  Scenario: Organizer can promote members to organizers
    Given I am logged in as "Alex Smith"
    And "Jo Johnson" is member of "Local organization" organization
    When I promote "Jo Johnson" to organizer of "Local organization"
    Then "Jo Johnson" is organizer of "Local organization"

  Scenario: Existing organizers cant be promoted to organizers
    Given I am logged in as "Alex Smith"
    When I promote "Alex Smith" to organizer of "Local organization"
    Then I will get an error saying that user is already an organizer
