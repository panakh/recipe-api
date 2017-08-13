Feature: Access Recipe CSV
  In order to test if the recipe is created
  As a developer
  I would like to read a csv file

  Scenario: Can check if recipe exists
    Given recipes
      |title| marketing_description|
      |Madras curry|      Indian curry |
    When I check if the recipe "Madras curry" exists
    Then the recipe is found