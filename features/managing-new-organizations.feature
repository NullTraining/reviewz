Feature:
  As an admin
  In order to manage content of the site
  I need to approve/reject new organizations

  Scenario: Approve new organization
    Given new "Local meetup" organization was created
    When I approve "Local meetup" organization
    Then "Local meetup" organization is approved


