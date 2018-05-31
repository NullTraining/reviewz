@organization
Feature:
  As a user
  In order to start new community events
  I need to first create an organization

  Scenario: Create an organization
    Given I am logged in as "Alex Smith"
    When I create "Local meetup" organization with description "Community of people doing ..." in "New York,US"
    Then there is new "Local meetup" organization

  Scenario: User that created new organization will be founder of the organization
    Given I am logged in as "Alex Smith"
    When I create "Local meetup" organization with description "Community of people doing ..." in "New York,US"
    Then "Alex Smith" is founder of "Local meetup" organization

  Scenario: User that created new organization is automatically an organizer
    Given I am logged in as "Alex Smith"
    When I create "Local meetup" organization with description "Community of people doing ..." in "New York,US"
    Then "Alex Smith" is organizer of "Local meetup" organization



