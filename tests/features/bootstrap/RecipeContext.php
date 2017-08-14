<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use SDK\GuzzleClientFactory;
use SDK\RecipeClient;
use SDK\RecipeCSVAccess;

/**
 * Defines application features from the specific context.
 */
class RecipeContext implements Context
{
    private $recipeClient;
    private $recipeCSVAccess;
    /**
     * @var string
     */
    private $csvPath;
    private $recipe;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(string $baseUrl, string $csvPath)
    {
        $guzzleClientFactory = new GuzzleClientFactory();
        $guzzle = $guzzleClientFactory->createClient($baseUrl);
        $this->recipeClient = new RecipeClient($guzzle);
        $this->recipeCSVAccess = new RecipeCSVAccess($csvPath);
        $this->csvPath = $csvPath;
    }

    /**
     * @BeforeScenario
     */
    public function deleteRecords()
    {
        $headers = [
            'id',
            'created_at',
            'updated_at',
            'box_type',
            'title',
            'slug',
            'short_title',
            'marketing_description',
            'calories_kcal',
            'protein_grams',
            'fat_grams',
            'carbs_grams',
            'bulletpoint1',
            'bulletpoint2',
            'bulletpoint3',
            'recipe_diet_type',
            'season',
            'base',
            'protein_source',
            'preparation_time_minutes',
            'shelf_life_days',
            'equipment_needed',
            'origin_country',
            'recipe_cuisine',
            'in_your_box',
            'gousto_reference'
        ];

        file_put_contents($this->csvPath, implode(',', $headers) . "\n");
    }

    /**
     * @When I create a recipe
     */
    public function iCreateARecipe()
    {
        $this->recipeClient->createRecipe($this->recipe);
    }

    /**
     * @Then the recipe is created
     */
    public function theRecipeIsCreated()
    {
        Assert::assertTrue($this->recipeCSVAccess->recipeExists($this->recipe['title']));
    }


    /**
     * @Given recipe
     */
    public function recipe(TableNode $table)
    {
        $this->recipe = $table->getColumnsHash()[0];
    }
}
