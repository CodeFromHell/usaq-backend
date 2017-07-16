Feature: UserFriends
  In order to add and remove friends
  As an user
  I need to be able to add and remove friends from my list

  Background:
    Given I am logged in as user
    And Exists an user with username "dave"
    And Exists an user with username "flex"
    And Exists an user with username "other"

  Scenario: try to add a friend
    Given I have a friend with username "dave"
    When I add new friend with username "flex"
    Then I see i have 2 friends

  Scenario: try to remove friend
    Given I have a friend with username "dave"
    When I remove a friend with username "dave"
    Then I see i have 0 friends
