Feature: Not logged in user can add a new occurence of apelido
  In order to create new apelido
  As a unregistered user
  I need to be able to create new or add myself to existing apelido

  Scenario: Successfully adding new apelido
    Given I am not logged in
    And apelido "Uirapuru" does not exists
    When I create new apelido "Uirapuru"
    Then apelido "Uirapuru" should exist
    And I should be notified about successful apelido creation

  Scenario: Creating user for existing apelido
    Given I am not logged in
    And apelido "Machado" does exist
    When I create new apelido "Machado"
    Then apelido "Machado" should exist
    And I should not be notified about successful apelido creation

