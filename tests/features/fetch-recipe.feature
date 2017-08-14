Feature: Fetch recipe
  In order to see a recipe
  As a customer
  I would like to fetch a recipe by its id

  Scenario: Recipe fetch by id
    Given recipes
      | id | created_at           | updated_at           | box_type   | title       | slug | short_title | marketing_description    | calories | protein | fat | carbs | bulletPoint1 | bulletPoint2 | bulletPoint3 | dietTypeId | season | base    | proteinSource | preparationTime | shelfLife | equipmentNeeded | originCountry | cuisine | inYourBox | goustoReference |
      | 1  | 30/06/2015  17:58:00 | 30/06/2015  17:58:00 | vegetarian | asian curry | asian-curry | asian_curry | curry description | 200      | 22      | 22  | 22    | b1           | b2           | b3           | meat       | all    | noodles | beef          | 30              | 2         | appetite        | uk            | asian   | in box    | 23              |
      | 2  | 30/06/2015  17:58:00 | 30/06/2015  17:58:00 | vegetarian | thai curry  | thai-curry  | thai_curry | curry description  | 200      | 22      | 22  | 22    | b1           | b2           | b3           | meat       | all    | noodles | beef          | 30              | 2         | appetite        | uk            | asian   | in box    | 23              |
    When I fetch recipe by id "1"
    Then the recipe is fetched