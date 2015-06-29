Feature: Existing user can add his description to apelido
  In order to put his own apelido description
  As a registered user
  I need to be able to create new description with image
  
  Scenario: Successfully adding new description with image
    Given account "loggedin@tlen.pl" does exist
    And I am logged in as "loggedin@tlen.pl"
    And apelido "Machado" does exist
    When I create for apelido "Machado" new description  "A little bird from Amazonian forest" with "abc.jpg" image as user "loggedin@tlen.pl"
    Then I should be notified about successful description creation
    When I create for apelido "Machado" new description  "A..." with "abc.jpg" image as user "loggedin@tlen.pl"
    Then I should be notified about failure on description creation
    And apelido "Machado" should have 1 description

  Scenario: Rating description
    Given I am logged in as "loggedin@tlen.pl"
    And apelido "Machado" does exist
    And user account "rating@tlen.pl" has been created
    And description for "Machado" by "loggedin@tlen.pl" user exists
    When 'user1@tlen.pl' rates '1' description by "loggedin@tlen.pl"
    Then description by "loggedin@tlen.pl" should be rated 1
    When 'user1@tlen.pl' rates '1' description by "loggedin@tlen.pl"
    Then description by "loggedin@tlen.pl" should be rated 1
    When 'user2@tlen.pl' rates '-1' description by "loggedin@tlen.pl"
    Then description by "loggedin@tlen.pl" should be rated 0