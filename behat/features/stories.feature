Feature:
  In order to be able to check the pagination buttons
  As an anonymous user
  We need to be able to press them and get new articles in the news section

  @api
  Scenario Outline: Visit Stories page and check pagination buttons
    Given I am an anonymous user
    When  I visit the "16-girls-16-stories-resistance" page
    And   I click on page "<page_number>"
    Then  I should not see "<page_number>" active

    Examples:
      | page_number |
      | 2           |
      | 3           |
