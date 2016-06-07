Feature:
  In order to be able to view the publications page
  As an anonymous user
  We need to be able to have access to the publications page

  @javascript
  Scenario: Check the articles filters.
    Given I am an anonymous user
    When  I visit the "publications" page
    And   I set the filters:
      | text          | #edit-combine                                 | Adolescent Boys and Young Men       |
      | date          | #edit-field-publication-date-value-value-year | 2016                                |
      | thematic area | #edit-field-thematic-area-tid-i18n            | -Comprehensive sexuality education  |
      | type          | #edit-field-type-of-publication-value         | Publication                         |
    And   I press "Go"
    Then  I should see "Adolescent Boys and Young Men"
