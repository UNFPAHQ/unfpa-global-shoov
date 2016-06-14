Feature:
  In order to be able to view the homepage
  As an anonymous user
  We need to be able to have access to the homepage

  @api
  Scenario Outline: Visit every link page from the homepage main sections.
    Given I am an anonymous user
    When  I visit the homepage
    Then  I should see the "<section>" with the "<link>" and have access to the link destination

  Examples:
    | section             | link                                         |
    | main menu           | Home                                         |
    | main menu           | About                                        |
    | main menu           | Topics                                       |
    | main menu           | Emergencies                                  |
    | main menu           | News                                         |
    | main menu           | Publications                                 |
    | main menu           | Media centre                                 |
    | sub menu            | Funds and funding                            |
    | sub menu            | Evaluation                                   |
    | sub menu            | UN Population Award                          |
    | sub menu            | Crisis in Syria                              |
    | sub menu            | All emergencies                              |
    | sub menu            | South Sudan Emergency                        |
    | news                | More News                                    |
    | publications        | More Publications                            |
    | videos              | Good Health and Well-being                   |
    | videos              | More Videos                                  |
    | events              | Browse all Events                            |
    | footer              | Events                                       |
    | footer              | Videos                                       |
    | footer              | Contact                                      |
    | footer              | Site map                                     |
    | footer              | Terms of use                                 |
    | footer              | State of World Population                    |
    | footer              | Safe birth. Even here.                       |
    | footer              | World Population Dashboard                   |
    | footer social links | Newsletter                                   |
    | footer social links | Twitter                                      |
    | footer social links | Facebook                                     |
    | footer social links | Gplus                                        |
    | footer social links | Youtube                                      |

