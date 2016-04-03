Feature:
  In order to be able to view the press release page
  As an anonymous user
  We need to be able to access the press release page

  @api
  Scenario Outline: Check that we get a default set of articles that appear on
  the page when we have no filters.
    Given I am an anonymous user
    When  I visit the "press/press-release" page
    Then  I should see "<title>"
  Examples:
    | title                                                 |
    | Essential Health Needs of Women Often Neglected       |

  @api
  Scenario: Check the articles filters.
    Given I am an anonymous user
    When  I visit the "press/press-release" page
    And   I set the filters:
      | text          | #edit-combine                                 | Girls Face Escalating Risk of Violence |
      | date          | #edit-field-news-date-value-value-year        | 2014                                   |
      | thematic area | #edit-field-thematic-area-tid-i18n            | -Maternal health                       |
    And   I press "Go"
    Then  I should see "Women, Girls Face Escalating Risk of Violence"
