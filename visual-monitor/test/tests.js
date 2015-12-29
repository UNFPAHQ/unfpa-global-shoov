'use strict';

var shoovWebdrivercss = require('shoov-webdrivercss');
var projectName = 'unfpa-global';

// This can be executed by passing the environment argument like this:
// PROVIDER_PREFIX=browserstack SELECTED_CAPS=chrome mocha
// PROVIDER_PREFIX=browserstack SELECTED_CAPS=ie11 mocha
// PROVIDER_PREFIX=browserstack SELECTED_CAPS=iphone5 mocha

var capsConfig = {
  'chrome': {
    project: projectName,
    'browser' : 'Chrome',
    'browser_version' : '42.0',
    'os' : 'OS X',
    'os_version' : 'Yosemite',
    'resolution' : '1024x768'
  },
  'ie11': {
    project: projectName,
    'browser' : 'IE',
    'browser_version' : '11.0',
    'os' : 'Windows',
    'os_version' : '7',
    'resolution' : '1024x768'
  },
  'iphone5': {
    'browser' : 'Chrome',
    'browser_version' : '42.0',
    'os' : 'OS X',
    'os_version' : 'Yosemite',
    'chromeOptions': {
      'mobileEmulation': {
        'deviceName': 'Apple iPhone 5'
      }
    }
  }
};

var selectedCaps = process.env.SELECTED_CAPS || undefined;
var caps = selectedCaps ? capsConfig[selectedCaps] : undefined;

var providerPrefix = process.env.PROVIDER_PREFIX ? process.env.PROVIDER_PREFIX + '-' : '';
var testName = selectedCaps ? providerPrefix + selectedCaps : providerPrefix + 'default';

var baseUrl = process.env.BASE_URL ? process.env.BASE_URL : 'http://www.unfpa.org';

var resultsCallback = process.env.DEBUG ? console.log : shoovWebdrivercss.processResults;

describe('Visual monitor testing', function() {

  this.timeout(99999999);
  var client = {};

  before(function(done){
    client = shoovWebdrivercss.before(done, caps);
  });

  after(function(done) {
    shoovWebdrivercss.after(done);
  });

  it('should show the home page',function(done) {
    client
      .url(baseUrl)
      .webdrivercss(testName + '.homepage', {
        name: '1',
        exclude:
          [
            // Carousel
            '.carousel .show',
            '.carousel .current',
            '.carousel ul li:nth-child(2)',
            '.carousel ul li:nth-child(3)',
            // stay connected.
            '.stay_connected img',
            // News panel
            '.pane-vw-news img',
            // Video pane
            '.pane-vw-video .media-youtube-video',
            // Latest Publications
            '.pane-vw-publications .cover-image',
            // Social Updates
            '#social_updates #twitter-widget-0',
          ],
        remove:
          [
            // Map
            '#block-custom-map-custom-home-map .pin',
            '.panel-col-center',
          ],
        hide:
          [
            // Unfpa slogan
            '.unfpa-slogan',
            // News panel
            '.pane-vw-news .title',
            '.pane-vw-news .summary',
            '.pane-vw-news .date-display-single',
            // Video pane
            '.pane-vw-video .views-field-title',
            // Latest Publications
            '.pane-vw-publications .title',
            '.pane-vw-publications .summary',
            // Events
            '.pane-vw-events .date-display-single',
            '.pane-vw-events .views-field-title',
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the About us page',function(done) {
    client
      .url(baseUrl + '/about-us')
      .webdrivercss(testName + '.about-us', {
        name: '1',
        hide:
          [
            // Social icons
            '.social-icons .stBubble_count',
            // Related Publications
            '.view-display-id-site_page_related_publication img',
            '.view-display-id-site_page_related_publication .description',
            // Related Resources
            '.view-display-id-site_page_related_resource img',
            '.view-display-id-site_page_related_resource .description',
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the emergencies page',function(done) {
    client
      .url(baseUrl + '/emergencies')
      .webdrivercss(testName + '.emergencies', {
        name: '1',
        exclude:
          [
            // Carousel
            '.carousel .show',
            // Banner
            '.field-name-field-section-banner img',
            // Resources
            '.pane-resources img',
            // News panel
            '.pane-vw-news img',
            // Video pane
            '.pane-vw-video .media-youtube-video',
            '.pane-vw-video .views-field-field-video-thumbnail-image',
            // Latest Publications
            '.pane-vw-publications .cover-image',
            // Social Updates
            '#twitter-widget-0',
          ],
        hide:
          [
            // Carousel
            '.carousel .thumbs ul li',
            // News panel
            '.pane-vw-news .title',
            '.pane-vw-news .summary',
            '.pane-vw-news .date-display-single',
            // Resources
            '.pane-resources .description',
            // Video pane
            '.pane-vw-video .views-field-title',
            // Latest Publications
            '.pane-vw-publications .title',
            '.pane-vw-publications .summary',
            // Events
            '.pane-vw-events .date-display-single',
            '.pane-vw-events .views-field-title',
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the news page',function(done) {
    client
      .url(baseUrl + '/news')
      .webdrivercss(testName + '.news', {
        name: '1',
        exclude:
          [
            // Article
            '.view-vw-news img'
          ],
        hide:
          [
            // Article
            '.view-vw-news .date-display-single',
            '.view-vw-news .right',
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the publications page',function(done) {
    client
      .url(baseUrl + '/publications')
      .webdrivercss(testName + '.publications', {
        name: '1',
        exclude:
          [
            // Publication item
            '.publication_item img',
          ],
        remove:
          [
            // Publication item
            '.publication_item .right .downButtons .view-content',
          ],
        hide:
          [
            // Publication item
            '.publication_item .right .title',
            '.publication_item .right .sub-title',
            '.publication_item .right > p',
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the How we work page',function(done) {
    client
      .url(baseUrl + '/how-we-work')
      .webdrivercss(testName + '.how-we-work', {
        name: '1',
        exclude:
          [
            // Related Publications
            '.view-display-id-site_page_related_publication img',
            // Related News
            '.pane-custom-custom-site-page-library img',
          ],
        hide:
          [
            // Social
            '.social .stBubble',
            // Related Publications
            '.view-display-id-site_page_related_publication .description',
            // Related News
            '.pane-custom-custom-site-page-library .description',
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the evaluation page',function(done) {
    client
      .url(baseUrl + '/evaluation')
      .webdrivercss(testName + '.evaluation', {
        name: '1',
        exclude:
          [
            // News on Evaluation
            '#fixed-block img',
            // Evaluation Office reports
            '.pane-custom-custom-library-2 img',
            // Key documents
            '.pane-custom-custom-library-3 img',
            // Resources
            '.pane-custom-custom-library-4 img',
          ],
        hide:
          [
            // News on Evaluation
            '#fixed-block .description',
            // Evaluation Office reports ,Key documents
            '.pane-custom-custom-library-2 .views-field-field-date',
            '.pane-custom-custom-library-2 .views-field-title',
            '.pane-custom-custom-library-2 .views-field-views-conditional-1',
            // Key documents
            '.pane-custom-custom-library-3 .views-field-field-date',
            '.pane-custom-custom-library-3 .views-field-title',
            '.pane-custom-custom-library-3 .views-field-views-conditional-1',
            // Resources
            '.pane-custom-custom-library-4 .views-field-field-date',
            '.pane-custom-custom-library-4 .views-field-title',
            '.pane-custom-custom-library-4 .views-field-views-conditional-1',
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });

  it('should show the dr-babatunde-osotimehin page',function(done) {
    client
      .url(baseUrl + '/about/dr-babatunde-osotimehin')
      .webdrivercss(testName + '.dr-babatunde-osotimehin', {
        name: '1',
        exclude:
          [
            // Social Updates
            '#social_updates',
          ],
        remove:
          [
            '.pane-vw-news'
          ],
        screenWidth: selectedCaps == 'chrome' ? [640, 960, 1200] : undefined,
      }, resultsCallback)
      .call(done);
  });


});
