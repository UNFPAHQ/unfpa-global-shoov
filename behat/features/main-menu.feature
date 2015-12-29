Feature:
  In order to be able to view the menu links
  As an anonymous user
  We need to be able to have access to the menu links pages

  @api
  Scenario Outline: Visit every link page from the main menu links.
    Given I am an anonymous user
    When  I visit the homepage
    Then  I should see the "<section>" with the "<link>" and have access to the link destination

  Examples:
    | section        | link                  |
    | main menu      | Home                  |
    | main menu      | About                 |
    | main menu      | Topics                |
    | main menu      | Emergencies           |
    | main menu      | News                  |
    | main menu      | Publications          |
    | main menu      | Press centre          |
    | sub menu       | Funds and funding     |
    | sub menu       | Evaluation            |
    | sub menu       | UN Population Award   |
    | sub menu       | Crisis in Syria       |
    | sub menu       | All emergencies       |
    | sub menu       | South Sudan Emergency |
