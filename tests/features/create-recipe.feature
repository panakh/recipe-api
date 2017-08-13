Feature: Create Recipe
  In order for my clients to see recipes
  As a business owner
  I would like create a recipe

  Scenario: Recipe creation with out a title
    Given title "Meatballs spaghetti"
    And marketing description "Lorem Ipsum"
    When I create a recipe
    Then the recipe is created