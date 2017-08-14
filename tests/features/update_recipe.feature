Feature: Update Recipe
  In order for my clients to get up to date recipes
  As a business owner
  I would like update a recipe

  Scenario: Rate recipe
    Given recipes
      | id | created_at           | updated_at           | box_type   | title       | slug        | short_title | marketing_description | calories | protein | fat | carbs | bulletPoint1 | bulletPoint2 | bulletPoint3 | dietTypeId | season | base    | proteinSource | preparationTime | shelfLife | equipmentNeeded | originCountry | cuisine | inYourBox | goustoReference | rating |
      | 1  | 30/06/2015  17:58:00 | 30/06/2015  17:58:00 | vegetarian | asian curry | asian-curry | asian_curry | curry description     | 200      | 22      | 22  | 22    | b1           | b2           | b3           | meat       | all    | noodles | beef          | 30              | 2         | appetite        | uk            | asian   | in box    | 23              |        |
    When I rate recipe 1 with rating 3
    Then recipe 1 rating is 3

    @wip
  Scenario: General update
    Given recipes
      | id | created_at           | updated_at           | box_type   | title       | slug        | short_title | marketing_description | calories | protein | fat | carbs | bulletPoint1 | bulletPoint2 | bulletPoint3 | dietTypeId | season | base    | proteinSource | preparationTime | shelfLife | equipmentNeeded | originCountry | cuisine | inYourBox | goustoReference | rating |
      | 1  | 30/06/2015  17:58:00 | 30/06/2015  17:58:00 | vegetarian | asian curry | asian-curry | asian_curry | curry description     | 200      | 22      | 22  | 22    | b1           | b2           | b3           | meat       | all    | noodles | beef          | 30              | 2         | appetite        | uk            | asian   | in box    | 23              |        |
    When I update the recipe
      | id | boxType |
      | 1  | meat    |
    Then recipe is updated
      | id | boxType |
      | 1  | meat    |
