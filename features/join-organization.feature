@user
Feature:
  As a user
  In order to attend events
  I need to join organization

  Background:
    Given there is a "New York Developer Ninjas" organization

  Scenario: User can join organization
    Given I am logged in as "Jo Johnson"
    When I join "New York Developer Ninjas" organization
    Then I should be a member of "New York Developer Ninjas" organization

  Scenario: Existing members can't join organization
    Given I am logged in as "Jo Johnson"
    And I'm a member of "New York Developer Ninjas" organization
    When I try to join "New York Developer Ninjas" organization
    Then I should see an error saying I'm already a member of the organization

  Scenario: Existing organizers can't join organization
    Given I am logged in as "Alex Smith"
    And "Alex Smith" is an organizer
    When I try to join "New York Developer Ninjas" organization
    Then I should see an error saying I'm already a member of the organization
    