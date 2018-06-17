@organization
Feature:
  As an admin
  In order to manage content of the site
  I need to approve/reject new organizations

  Scenario: Approve new organization
    Given new "New York Developer Ninjas" organization was created
    When I approve "New York Developer Ninjas" organization
    Then "New York Developer Ninjas" organization is approved

  Scenario: Reject new organization
    Given new "New York Developer Ninjas" organization was created
    When I reject "New York Developer Ninjas" organization
    Then "New York Developer Ninjas" organization is rejected


