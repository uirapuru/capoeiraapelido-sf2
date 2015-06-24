Feature: Not logged in user can add a new occurence of apelido
  In order to became a registered user of apelido
  As a unregistered user
  I need to be able to create new or add myself to existing apelido
  And get a valid token to confirm operation or signup in system for further changes

  Scenario: Successfully adding new apelido
    Given I am not logged in
    And apelido "Uirapuru" does not exists
    And I add to apelido "Uirapuru" user with email "uirapuru@tlen.pl", group "Camangula", city "Gdynia", country "Poland"
    Then apelido "Uirapuru" should exist
    And my account "uirapuru@tlen.pl" created
    And I should be notified about successful apelido creation
    And I should be notified about successful account creation
    And I am logged in as "uirapuru@tlen.pl"

  Scenario: Creating user for existing apelido
    Given I am not logged in
    And apelido "Machado" does exist
    When I create new apelido "Machado"
    And I add to apelido "Machado" user with email "machado@tlen.pl", group "Camangula", city "Gdynia", country "Poland"
    Then apelido "Machado" should exist
    And my account "machado@tlen.pl" created
    And I should not be notified about successful apelido creation
    And I should be notified about successful account creation
    And I am logged in as "machado@tlen.pl"

  Scenario: Creating user that already exists
    Given I am not logged in
    And apelido "Machado" does exist
    And user account "existing@tlen.pl" has been created
    When I add to apelido "Machado" user with email "existing@tlen.pl", group "Camangula", city "Gdynia", country "Poland"
    Then my account "existing@tlen.pl" created
    And I should be notified about error on account creation

