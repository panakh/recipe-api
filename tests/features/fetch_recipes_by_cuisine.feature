Feature: Fetch recipes by cuisine
  In order to see recipes by cuisine
  As a customer
  I would like to fetch all recipes by cuisine

  Scenario: Recipe fetch by cuisine
    Given recipes
      | id | created_at           | updated_at           | box_type   | title               | slug          | short_title         | marketing_description | calories | protein | fat | carbs | bulletPoint1 | bulletPoint2 | bulletPoint3 | dietTypeId | season | base    | proteinSource | preparationTime | shelfLife | equipmentNeeded | originCountry | cuisine | inYourBox | goustoReference |ratint|
      | 1  | 30/06/2015  17:58:00 | 30/06/2015  17:58:00 | vegetarian | asian curry         | asian-curry   | asian_curry         | curry description     | 200      | 22      | 22  | 22    | b1           | b2           | b3           | meat       | all    | noodles | beef          | 30              | 2         | appetite        | uk            | asian   | in box    | 23              |      |
      | 2  | 30/06/2015  17:58:00 | 30/06/2015  17:58:00 | vegetarian | thai curry          | thai-curry    | thai_curry          | curry description     | 200      | 22      | 22  | 22    | b1           | b2           | b3           | meat       | all    | noodles | beef          | 30              | 2         | appetite        | uk            | thai    | in box    | 23              |      |
      | 3  | 30/06/2015  17:58:00 | 30/06/2015  17:58:00 | vegetarian | another asian curry | another-curry | another_asian_curry | curry description     | 200      | 22      | 22  | 22    | b1           | b2           | b3           | meat       | all    | noodles | beef          | 30              | 2         | appetite        | uk            | asian   | in box    | 23              |      |
    And results per page is 1
    When page is 1
    And I fetch recipe by cuisine "asian"
    Then recipes are fetched
      | id |
      | 1  |
    When page is 2
    And I fetch recipe by cuisine "asian"
    Then recipes are fetched
      | id |
      | 3  |