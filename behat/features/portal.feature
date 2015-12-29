Feature:
  In order to be able to search for articles in the transparency portal page
  As an anonymous user
  We need to be able to filter article in the portal page

  @javascript
  Scenario Outline: Visit Transparency Portal page, and check the search filter
    Given I am an anonymous user
    When  I visit the "transparency-portal" page
    And   I fill "<year>" in the year field and "<activities>" in the Programme Activities field
    Then  I should see the title "<title>"

    Examples:
      | year | activities               | title                                   |
      | 2014 | Integrated SRH services  | Integrated SRH services expenses in USD |
      | 2014 | Adolescents and youth    | Adolescents and youth expenses in USD   |

  @javascript
  Scenario Outline: Visit Transparency Portal page, and check region selector
    Given I am an anonymous user
    When  I visit the "transparency-portal" page
    And   I click on "pencil" button and "<region>" link in the menu
    Then  I should see the title "<title>"

    Examples:
      | region     | title           |
      | Argentina  | UNFPA Argentina |
      | Thailand   | UNFPA Thailand  |

  @javascript
  Scenario: Visit Transparency Portal page, and check resources hover
    Given I am an anonymous user
    When  I visit the "transparency-portal" page
    And   I click on "core" tab
    Then I should see the title "2014 worldwide programme expenses (core)"
