Feature:
  In order to be able to view the publications page
  As an anonymous user
  We need to be able to have access to the publications page

  @javascript
  Scenario: Check the articles filters.
    Given I am an anonymous user
    When  I visit the "publications" page
    And   I set the filters:
      | text          | #edit-combine                                 | UN report on obstetric fistula 2014 |
      | date          | #edit-field-publication-date-value-value-year | 2015                                |
      | thematic area | #edit-field-thematic-area-tid-i18n            | -Family planning                    |
      | type          | #edit-field-type-of-publication-value         | State of World Population           |
    And   I press "Go"
    Then  I should see "State of World Population 2015"
