Feature:
  In order to receive my purchases
  As a customer
  I must provide a delivery address to my address book

  Scenario: I want to add an address
    Given I am a registred customer
    When I add a new address to my address book
    And I register "Steve Roger", "100 Rue de Rivoli", "75001", "Paris", "France"
    And I mark it as delivery address
    Then address "Steve Roger", "100 Rue de Rivoli", "75001", "Paris", "France" should be my default address




