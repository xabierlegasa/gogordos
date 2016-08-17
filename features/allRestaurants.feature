Feature: All restaurant list
  In order to see all recommendations
  As a user
  I need to be able to see several recommendations in the home page from all the users


  Scenario: See recommendations in the home page
    Given I am in the home page
    Then I should see five restaurants from all users
