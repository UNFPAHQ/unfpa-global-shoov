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
    | section         | link                                            |
    | news            | 507 maternal deaths take place every day        |
    | news            | Post-rape care needed to protect against HIV    |
    | news            | More News                                       |
    | publications    | GBViE Standards                                 |
    | publications    | State of World Population 2015                  |
    | publications    | More Publications                               |
    | videos          | Good Health and Well-being                      |
    | videos          | More Videos                                     |
    | events          | World AIDS Day                                  |
    | events          | Global Conference on Ending Violence            |
    | events          | Browse all Events                               |
