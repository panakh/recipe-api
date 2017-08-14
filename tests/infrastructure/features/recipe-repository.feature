Feature: Save Recipe
  In order to read recipe
  As a system
  I would like to save a recipe

  Scenario: Save Recipe
    Given recipe
      |boxType    | title       | shortTitle  | marketingDescription    | calories | protein | fat | carbs | bulletPoint1 | bulletPoint2 | bulletPoint3 | dietTypeId | season | base    | proteinSource | preparationTime | shelfLife | equipmentNeeded | originCountry | cuisine | inYourBox | goustoReference |
      |vegetarian | asian curry | asian_curry | asian curry description | 200      | 22      | 22  | 22    | b1           | b2           | b3           | meat       | all    | noodles | beef          | 30              | 2         | appetite        | uk            | asian   | in box    | 23              |
    When I save recipe
    Then recipe is saved