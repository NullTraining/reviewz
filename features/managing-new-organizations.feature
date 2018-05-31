@organization
Feature:
  As an admin
  In order to manage content of the site
  I need to approve/reject new organizations

  @app
  Scenario: Approve new organization
    Given new "Local meetup" organization was created
    When I approve "Local meetup" organization
    Then "Local meetup" organization is approved

  Scenario: Reject new organization
    Given new "Local meetup" organization was created
    When I reject "Local meetup" organization
    Then "Local meetup" organization is rejected


