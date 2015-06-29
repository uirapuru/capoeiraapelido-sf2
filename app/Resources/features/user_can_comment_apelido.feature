Feature: Existing user can add his comment to apelido
  In order to put his own apelido comment
  As a registered user
  I need to be able to create new comment with image
  
  Scenario: Successfully adding new comment with image
    Given apelido "Machado" does exist
    When I create for apelido "Machado" new comment "A little bird from Amazonian forest" as user "loggedin@tlen.pl"
    Then I should be notified about successful comment creation
    And apelido "Machado" should have 2 comment
