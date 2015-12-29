Feature:
  In order to be able to view the site in any language (EN|ES|FR)
  As an anonymous user
  We need to be able to pick a language and have access to the site
  content on each language

  @api
  Scenario Outline: Pick a language and validate that the main menu links
    are translated into the chosen site language
    Given I am an anonymous user
    When  I visit the homepage and I pick the language "<language>"
    Then  I should see that the "<text>" inside the "<section>" was translated into the site current language

  Examples:
    | language  | section         | text                                                                              |
    | EN        | navigation links | Home, About, Topics, Emergencies, News, Publications, Press centre                |
    | ES        | navigation links | Inicio, Acerca de, Temas, Emergencias, Noticias, Publicaciones, Centro de prensa  |
    | FR        | navigation links | Accueil, À propos, Thèmes, Urgences, Actualités, Publications, Centre de presse   |


  @api
  Scenario Outline: Pick a language and validate that the site slogan
  is translated into the chosen site language
    Given I am an anonymous user
    When  I visit the homepage and I pick the language "<language>"
    Then  I should see that the "<text>" inside the "<section>" was translated into the site current language

  Examples:
    | language  | section | text                                                                                                                                          |
    | EN        | slogan  | UNFPA: Delivering a world where every pregnancy is wanted       |
    | ES        | slogan  | UNFPA: Contribuyendo a un mundo donde cada embarazo sea deseado |
    | FR        | slogan  | UNFPA: Réaliser un monde où chaque grossesse est désirée        |


  @api
  Scenario Outline: Pick a language and validate that the site logo
  is translated into the chosen site language
    Given I am an anonymous user
    When  I visit the homepage and I pick the language "<language>"
    Then  I should see that the "<text>" inside the "<section>" was translated into the site current language

  Examples:
    | language  | section   | text                                                                                                                                          |
    | EN        | site logo | United Nations Population Fund             |
    | ES        | site logo | Fondo de Población de las Naciones Unidas  |
    | FR        | site logo | Fonds des Nations Unies pour la population |
