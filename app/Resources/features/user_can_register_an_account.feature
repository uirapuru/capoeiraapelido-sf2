Feature: Not logged in user can add a new occurence of apelido
  In order to became a registered user of apelido
  As a unregistered user
  I need to be able to create new or add myself to existing apelido
  And get a valid token to confirm operation or signup in system for further changes

  Scenario: Successfully adding new apelido
    Given I am not logged in
    And apelido "Uirapuru" does not exists
    And I add to apelido "Uirapuru" user with email "uirapuru@tlen.pl", group "Camangula", city "Gdynia", country "Poland"

    Then apelido "Uirapuru" should be saved
    And my account "uirapuru@tlen.pl" created
    And I should be notified about successful apelido creation
    And I should be notified about successful account creation
    And I am logged in as "uirapuru@tlen.pl"
    And I should get a valid token for my account

#  Scenario: Creating user for existing apelido
#    Given I am not logged in
#    And apelido "Machado" does exist
#    And country "Germany" does exist
#    And city "Berlin" does exist
#    And group "Abada" does exist
#    When I create new apelido "Machado" with email "machado@tlen.pl", group "Abada", city "Berlin", country "Germany"
#    Then apelido "Machado" should be saved
#    And my account "machado@tlen.pl" created
#    And I should not be notified about successful apelido creation
#    And I should be notified about successful account creation
#    And I should not be notified about group creation
#    And I should not be notified about city creation
#    And I should not be notified about country creation
#    And I am logged in as "machado@tlen.pl"
#    And I should get a valid token for my account
#