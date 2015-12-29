<?php

use Drupal\DrupalExtension\Context\DrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

class FeatureContext extends DrupalContext implements SnippetAcceptingContext {

  /**
   * @When /^I visit the homepage$/
   */
  public function iVisitTheHomepage() {
    $this->getSession()->visit($this->locatePath('/'));
  }

  /**
   * @Then I should see the :arg1 with the :arg2 and have access to the link destination
   */
  public function iShouldSeeTheWithTheAndHaveAccessToTheLinkDestination($section, $link_text) {
    $page = $this->getSession()->getPage();

    switch ($section) {
      case 'main menu':
        $link = $page->find('xpath', '//section[@id="block-system-main-menu"]//ul[@class="menu"]//li[contains(@class, "level-1")]/a[contains(., "' . $link_text .'")]');
        break;

      case 'sub menu':
        $link = $page->find('xpath', '//section[@id="block-system-main-menu"]//ul[@class="menu"]//li[contains(@class, "level-2")]/a[contains(., "' . $link_text .'")]');
        break;

      case 'events':
        $link = $page->find('xpath', '//div[contains(@class, "view-vw-events")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'carousel':
        $link = $page->find('xpath', '//div[contains(@class, "carousel")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'news':
        $link = $page->find('xpath', '//div[contains(@class, "pane-vw-news")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'videos':
        $link = $page->find('xpath', '//div[contains(@class, "pane-vw-video")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'publications':
        $link = $page->find('xpath', '//div[contains(@class, "pane-vw-publications")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'stay connected':
        $link = $page->find('xpath', '//div[contains(@class, "stay_connected")]//a[contains(., "' . $link_text .'")]');
        break;

      case 'footer':
        $link = $page->find('xpath', '//div[@id="footer_links"]//ul[@class="menu"]//li[contains(@class, "level-1")]/a[contains(., "' . $link_text .'")]');
        break;

      case 'footer social links':
        $link = $page->find('xpath', '//div[@id="footer_social"]//a[contains(., "' . $link_text .'")]');
        break;

      default:
        $link = FALSE;
    }

    // In case we have no links.
    if (!$link) {
      $variables = array('@section' => $section, '@link' => $link_text);
      throw new \Exception(format_string("The link: '@link' was not found on section: '@section'", $variables));
    }

    // Check if we have access to the page (link url).
    $link->click();
    $url = $this->getSession()->getCurrentUrl();
    $code = $this->getSession()->getStatusCode();
    // In case the link url doesn't return a status code of '200'.
    if ($code != '200')  {
      $variables = array(
        '@code' => $code,
        '@url' => $url,
        '@section' => $section,
      );
      $message = "The page code is '@code' it expects it to be '200' (from url: @url at section: @section)";
      throw new \Exception(format_string($message, $variables));
    }
  }

  /**
   * @When I visit the homepage and I pick the language :arg1
   */
  public function iVisitTheHomepageAndIPickTheLanguage($language) {

    // In case no language was supplied as an argument.
    if (empty($language)) {
      throw new \Exception('No language was picked for the site');
    }

    // Get the target language link.
    $page = $this->getSession()->getPage();
    $language = strtolower($language);
    $language_link = $page->find('xpath', '//header[@id="header"]//ul[@class="language-switcher-locale-url"]//li[contains(@class, "' . $language . '")]//a');

    // In case no link was found for the target language.
    if (!$language_link) {
      throw new \Exception(format_string("No language link was found for the language: @language", array('@language' => $language)));
    }

    // Preserve the current language.
    $language_link->click();
  }

  /**
   * @Then I should see that the :arg1 inside the :arg2 was translated into the site current language
   */
  public function iShouldSeeThatTheInsideTheWasTranslatedIntoTheSiteCurrentLanguage($text, $section) {
    $page = $this->getSession()->getPage();

    switch ($section) {
      case 'navigation links':
        // Get the target links.
        $links = $page->findAll('xpath', '//section[@id="block-system-main-menu"]//ul[@class="menu"]//li[contains(@class, "level-1")]/a');

        // The translated text to compare against.
        $translated_text = explode(', ', $text);
        foreach ($links as $index => $link) {
          // In case the link text is not translated accordingly.
          if (!in_array($link->getText(), $translated_text)) {
            $variables = array(
              '@translation' => $link->getText(),
              '@number' => $index + 1,
            );
            throw new \Exception(format_string("The translation: '@translation' for link number: @number was not found", $variables));
          }
        }
        break;

      case 'slogan':
        $slogan = $page->find('xpath', '//section[@id="main"]//p[@class="unfpa-slogan"]');
        if (strpos($slogan->getHtml(), $text) === false) {
          throw new \Exception(format_string("The slogan: '@slogan' was not found", array('@slogan' => $text)));
        }
        break;

      case 'site logo':
        $logo_image = $page->find('xpath', '//header[@id="header"]//a[@id="logo"]//img');

        // In case the image 'alt'' attribute is in incorrect.
        if (strpos($logo_image->getAttribute('alt'), $text ) === false) {
          throw new \Exception(format_string("The logo image alt text: '@text' was not found", array('@text' => $text)));
        }
        break;

      default:
        throw new \Exception(format_string("The section: @section isn't valid", array('@section' => $section)));
    }
  }

  /**
   * @When I visit the :arg1 page
   */
  public function iVisitThePage($page) {
    $this->getSession()->visit($this->locatePath('/' . $page));
  }

  /**
   * @When I fill :arg1 in the year field and :arg2 in the Programme Activities field
   */
  public function iFillYearInTheYearFieldAndActivitiesInTheProgrammeActivitiesField($year, $activities) {
    $page_url = $this->getSession()->getCurrentUrl();
    $page = $this->getSession()->getPage();
    $activities_checkboxes = array(
      'Integrated SRH services' => '#edit-s01',
      'Adolescents and youth' => '#edit-s02',
    );

    // Select the year value in the year select.
    if (!$year_select = $page->findById('edit-year')) {
      throw new \Exception(format_string("Could not find the Year field at '@url'.", array('@url' => $page_url)));
    }
    $year_select->selectOption($year);

    // Open Programme Activities.
    if (!$activities_select = $page->find('css', '.select-activity')) {
      throw new \Exception(format_string("Could not find the field `Programme Activities` at '@url'.", array('@url' => $page_url)));
    }
    $activities_select->click();

    // Choose specific activity.
    if (!$activities_select_checkboxes = $page->find('css', $activities_checkboxes[$activities] . ' .activities-checkboxes')) {
      throw new \Exception(format_string("Could not find the checkboxes '@activities' at '@url'.", array('@activities' => $activities, '@url' => $page_url)));
    }
    // Click to uncheck all the checkboxes - depend on the activities.
    $activities_select_checkboxes->unCheck();
    // Click to check one of the checkboxes.
    $activities_select_checkboxes->check();

    // Submit the form.
    if (!$submit_button = $page->findById('edit-submit')) {
      throw new \Exception(format_string("Could not find the Submit button at '@url'.", array('@url' => $page_url)));
    }
    $submit_button->click();

    $this->iWaitForCssElement("#active-activities","appear");
  }

  /**
   * @Then I should see the title :arg1
   */
  public function iShouldSeeTheTitle($title) {
    $page_url = $this->getSession()->getCurrentUrl();
    $page = $this->getSession()->getPage();

    // Get the title page.
    if (!$text = $page->getText()) {
      throw new \Exception(format_string("The title: '@title' was not found in '@url' after search for the same activities.", array('@title' => $title, '@url' => @$page_url)));
    }
  }

  /**
   * @When I click on :arg1 button and :arg2 link in the menu
   */
  public function iClickOnPencilButtonAndRegionLinkInTheMenu($pencil, $region){
    $page_url = $this->getSession()->getCurrentUrl();
    $page = $this->getSession()->getPage();
    $countries = array(
      "Argentina" => "unfpa-argentina",
      "Thailand" => "unfpa-thailand",
    );

    // Click the countries index button.
    if (!$button = $page->find('css', '.' . $pencil)) {
      throw new \Exception(format_string("Could not find the `Select region, country or territory` button at '@url'.", array('@url' => $page_url)));
    }
    $button->click();

    // click the country link.
    if (!$country_link = $page->find('css', 'a[href="transparency-portal/' . $countries[$region] . '"]')) {
      throw new \Exception(format_string("Could not find the '@country' link in `Select region, country or territory` button at '@url'.", array('@country' => $region, '@url' => $page_url)));
    }
    $country_link->click();
  }

  /**
   * @When I click on :arg1 tab
   */
  public function iClickOnButtonTab($button) {
    $page_url = $this->getSession()->getCurrentUrl();
    $page = $this->getSession()->getPage();

    // Click the Donut tab.
    if (!$chart_tabs = $page->find('css', 'li[tabfor="' . $button . '"]')) {
      throw new \Exception(format_string("Could not find the '@core' button in `donut_chart_tab` button at '@url'.", array('@core' => $button, '@url' => $page_url)));
    }
    $chart_tabs->click();
  }

  /**
   * @Then /^I wait for css element "([^"]*)" to "([^"]*)"$/
   */
  private function iWaitForCssElement($element, $appear) {
    $xpath = $this->getSession()->getSelectorsHandler()->selectorToXpath('css', $element);
    $this->waitForXpathNode($xpath, $appear == 'appear');
  }

  /**
   * Helper function; Execute a function until it return TRUE or timeouts.
   *
   * @param $fn
   *   A callable to invoke.
   * @param int $timeout
   *   The timeout period. Defaults to 10 seconds.
   *
   * @throws Exception
   */
  private function waitFor($fn, $timeout = 10000) {
    $start = microtime(true);
    $end = $start + $timeout / 1000.0;
    while (microtime(true) < $end) {
      if ($fn($this)) {
        return;
      }
    }
    throw new \Exception('waitFor timed out.');
  }

  /**
   * Wait for an element by its XPath to appear or disappear.
   *
   * @param string $xpath
   *   The XPath string.
   * @param bool $appear
   *   Determine if element should appear. Defaults to TRUE.
   *
   * @throws Exception
   */
  private function waitForXpathNode($xpath, $appear = TRUE) {
    $this->waitFor(function ($context) use ($xpath, $appear) {
      try {
        $nodes = $context->getSession()->getDriver()->find($xpath);
        if (count($nodes) > 0) {
          $visible = $nodes[0]->isVisible();
          return $appear ? $visible : !$visible;
        }
        return !$appear;
      } catch (WebDriver\Exception $e) {
        if ($e->getCode() == WebDriver\Exception::NO_SUCH_ELEMENT) {
          return !$appear;
        }
        throw $e;
      }
    });
  }

  /**
   * @When I should see on the map a pin with :arg1 from :arg2
   */
  public function iShouldSeeOnTheMapAPinWithFrom($country, $type) {
    $page = $this->getSession()->getPage();

    // Pin type query selector.
    $by_type = '//a[contains(@class, "pin ' . $type . '")]';
    // Pin country query selector.
    $by_country = '/following-sibling::div[@class="quick-info" and contains(., "' . $country .'")]';

    // In case pin isn't found on the map.
    if (!$pin = $page->find('xpath', '//div[@id="unfpa_worldwide"]//div[@class="map-wrapper"]' . $by_type . $by_country)) {
      $variables = array('@country' => $country, '@type' => $type);
      throw new \Exception(format_string("The pin form type: '@type' with country: '@country' was not found on the map", $variables));
    }
  }

  /**
   * @When I click on page :arg1
   */
  function iClickOnPageNumber($page_number) {
    $page_url = $this->getSession()->getCurrentUrl();
    $page = $this->getSession()->getPage();

    // Get the pagination button
    if(!$button = $page->findLink("Go to page " . $page_number)) {
      throw new Exception(format_string("The pagination button '@number' was not found on the page '@url'", array('@number' => $page_number, '@url' => $page_url)));
    }
    $button->click();
  }

  /**
   * @Then I should not see :arg1 active
   */
  function iShouldNotSeePageNumberActive($page_number) {
    $page_url = $this->getSession()->getCurrentUrl();
    $page = $this->getSession()->getPage();

    // Get the pagination button.
    if($button = $page->findLink("Go to page " . $page_number)) {
      throw new Exception(format_string("The pagination button '@number' is active at '@url'", array('@number' => $page_number, '@url' => $page_url)));
    }
  }

  /**
   * @Given /^I set the filters:$/
   */
  public function iSetTheFilters(TableNode $table) {
    $page = $this->getSession()->getPage();

    // Iterate over each filter and set it's field value accordingly.
    foreach ($table->getRows() as $filters => $filter_data) {

      // Get the filter data: (name, element selector ,value).
      list($filter_name, $filter_id, $filter_value) = $filter_data;

      // In case the target element is not found.
      if (!$element = $page->findById($filter_id)) {
        $variables = array(
          '@name' => $filter_name,
          '@id' => $filter_id,
        );
        throw new \Exception(format_string("The '@name' filter field with id: '@id' was not found", $variables));
      }
      $this->setElementValue($element, $filter_value);
    }
  }

  /**
   * Set an element value according to its type e.g. input || select etc.
   *
   * @param $element
   *  The target  html element to set it's value.
   * @param $value
   *  The value to be assigned to the element.
   * @throws Exception
   * @return bool
   *  In case of a success returns TRUE else throws an Exception.
   */
  private function setElementValue($element, $value) {

    // Get the element tag name.
    $tag_name = $element->getTagName();

    // Flag to identify if an element was set with a value.
    switch ($tag_name) {
      case 'input':
        $element->setValue($value);
        $element_is_set = TRUE;
        break;

      case 'select':
        $element->selectOption($value);
        $element_is_set = TRUE;
        break;

      default:
        $element_is_set = FALSE;
    }

    if (!$element_is_set) {
      $variables = array(
        '@xpath' => $element->getXpath(),
        '@value' =>$value,
      );
      throw new \Exception(format_string("The element: '@xpath' was not set with the value: '@value'", $variables));
    }

    return $element_is_set;
  }
}
