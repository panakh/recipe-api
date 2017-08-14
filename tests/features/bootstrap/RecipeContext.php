<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Gousto\RecipeRepository;
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
    private $schema = [
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
        'recipe_diet_type_id',
        'season',
        'base',
        'protein_source',
        'preparation_time_minutes',
        'shelf_life_days',
        'equipment_needed',
        'origin_country',
        'recipe_cuisine',
        'in_your_box',
        'gousto_reference',
        'rating'
    ];
    /**
     * @var string
     */
    private $csvPath;
    private $recipe;
    private $fetchedRecipe;
    private $writtenRecipes = [];
    private $fetchId;
    private $fetchedRecipes;
    private $resultsPerPage;
    private $page;


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
    public function writeHeaders()
    {
        file_put_contents($this->csvPath, implode(',', $this->schema) . "\n");
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

    /**
     * @Given recipes
     */
    public function recipes(TableNode $table)
    {
        $this->writeHeaders();
        $handle = fopen($this->csvPath, 'a+');

        foreach ($table->getColumnsHash() as $recipe) {
            fputcsv($handle, $recipe);
            $this->writtenRecipes[$recipe['id']] = $recipe;
        }
        fclose($handle);
    }

    /**
     * @When I fetch recipe by id :id
     */
    public function iFetchRecipeById(int $id)
    {
        $this->fetchId = $id;
        $this->fetchedRecipe = $this->recipeClient->getRecipe($id);
    }

    /**
     * @Then the recipe is fetched
     */
    public function theRecipeIsFetched()
    {
        Assert::assertEquals(
            $this->writtenRecipes[$this->fetchId]['slug'],
            $this->fetchedRecipe['slug']
        );
    }


    /**
     * @When I fetch recipe by cuisine :cuisine
     */
    public function iFetchRecipeByCuisine(string $cuisine)
    {
        $fetchedRecipes = $this->recipeClient->getRecipes([
                'cuisine' => $cuisine,
                'page' => [
                    'size' => $this->resultsPerPage,
                    'number' => $this->page
                ]
            ]
        );

        $indexed = [];
        foreach ($fetchedRecipes as $recipe) {
            $indexed[$recipe['id']] = $recipe;
        }
        $this->fetchedRecipes = $indexed;

    }

    /**
     * @Then recipes are fetched
     */
    public function recipesAreFetched(TableNode $table)
    {
        Assert::assertEquals(count($table),count($this->fetchedRecipes));
        foreach ($table as $recipe) {
            Assert::assertTrue(array_key_exists($recipe['id'], $this->fetchedRecipes));
        }
    }

    /**
     * @Given results per page is :resultsPerPage
     */
    public function resultsPerPageIs(int $resultsPerPage)
    {
        $this->resultsPerPage = $resultsPerPage;
    }

    /**
     * @When page is :page
     */
    public function pageIs(int $page)
    {
        $this->page = $page;
    }

    /**
     * @When I rate recipe :recipeId with rating :rating
     */
    public function iRateRecipeWithRating(int $recipeId, int $rating)
    {
        $this->recipeClient->rateRecipe($recipeId, $rating);
    }

    /**
     * @Then recipe :arg1 rating is :arg2
     */
    public function recipeRatingIs(int $recipeId, int $rating)
    {
        $recipe = $this->recipeClient->getRecipe($recipeId);
        Assert::assertEquals($recipeId, $recipe['id']);
        Assert::assertEquals($rating, $recipe['rating']);
    }

    /**
     * @When I update the recipe
     */
    public function iUpdateTheRecipe(TableNode $table)
    {
        $recipe = $table->getColumnsHash()[0];
        $id = $recipe['id'];
        unset($recipe['id']);
        $this->recipeClient->updateRecipe($id, $recipe);
    }

    /**
     * @Then recipe is updated
     */
    public function recipeIsUpdated(TableNode $table)
    {
        $recipeExpected = $table->getColumnsHash()[0];
        $recipe = $this->recipeClient->getRecipe($recipeExpected['id']);

        Assert::assertEquals($recipeExpected['id'], $recipe['id']);
        unset($recipeExpected['id']);
        foreach ($recipeExpected as $key => $value) {
            Assert::assertEquals($value, $recipe[$key]);
        }
    }
}
