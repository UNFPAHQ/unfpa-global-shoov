Feature:
  In order to be able to view for transparency portal statistic data
  As an anonymous user
  We need to be able to access the portal page

  @javascript
  Scenario: Visit Transparency Portal page, and check the search filter
    Given I am an anonymous user
    When  I visit the "transparency-portal" page
    And   I set the filters:
      | Programme Activities           | .select-activity | select    |
      | Programme Activities Checkboxs | #edit-s02-p2     | unChecked |
      | Integrated SRH services        | #edit-s01-p1     | checked   |
    And   I press "Submit"
    Then  I should see the portal title "Integrated SRH services expenses in USD"

  @javascript
  Scenario: Visit Transparency Portal page, and check region selector
    Given I am an anonymous user
    When  I visit the "transparency-portal" page
    And   I click "Select region, country or territory"
    And   I click "Argentina"
    Then  I should see "UNFPA Argentina"

  @api
  Scenario Outline: Visit Transparency Portal page, and check region selector
    Given I am an anonymous user
    When  I visit the "transparency-portal" page
    And   I click "<tab name>"
    Then  I should see "<paragraph>"

    Examples:
      | tab name      | paragraph                                                               |
      | Total need    | This map shows each country's or territory's need for UNFPA support     |

  @javascript
  Scenario Outline: Check the tooltip hover/click on the Transparency Portal page
    Given I am an anonymous user
    When  I visit the "transparency-portal" page
    And   I "<action>" on "<chart column>" from "<chart title>" chart
    Then  I should see "<result>"

    Examples:
      | chart title                         | chart column       | action | result                                       |
      | World Map                           | Latin America      | hover  | Latin America & the Caribbean                |
      | World Map                           | Asia               | hover  | Asia & the Pacific                           |
