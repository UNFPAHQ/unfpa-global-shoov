Feature:
  In order to be able to view the site Footer
  As an anonymous user
  We need to be able to have access to the footer

  @api
  Scenario Outline: Visit every main link page from the site footer
    Given I am an anonymous user
    When  I visit the homepage
    Then  I should see the "<section>" with the "<link>" and have access to the link destination

    Examples:
      | section             | link                          |
      | footer              | Jobs                          |
      | footer              | Events                        |
      | footer              | Videos                        |
      | footer              | Contact                       |
      | footer              | Site map                      |
      | footer              | Terms of use                  |
      | footer              | state of world population     |
      | footer              | Safe birth. Even here.        |
      | footer              | World Population Dashboard    |
      | footer social links | Newsletter                    |
      | footer social links | Twitter                       |
      | footer social links | Facebook                      |
      | footer social links | LinkedIn                      |
      | footer social links | Gplus                         |
      | footer social links | Youtube                       |
