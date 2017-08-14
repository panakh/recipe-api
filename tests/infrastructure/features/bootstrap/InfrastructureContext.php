<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Gousto\Recipe;
use Gousto\RecipeRepository;
use PHPUnit\Framework\Assert;
use SDK\GuzzleClientFactory;
use SDK\RecipeClient;
use SDK\RecipeCSVAccess;

/**
 * Defines application features from the specific context.
 */
class InfrastructureContext implements Context
{
    /**
     * @var string
     */
    private $csvPath;
    private $recipeRepository;
    private $recipe;
    private $fetchedRecipe;
    private $fetchId;
    private $writtenRecipes = [];
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
        'gousto_reference'
    ];
    private $fetchedRecipes;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     * @param string $csvPath
     */
    public function __construct(string $csvPath)
    {
        $this->csvPath = $csvPath;
        $this->recipeRepository = new RecipeRepository($this->csvPath);
    }

    /**
     * @AfterScenario
     * @BeforeScenario
     */
    public function cleanFile()
    {
        file_put_contents($this->csvPath, '');
    }

    public function writeHeaders()
    {
        file_put_contents($this->csvPath, implode(',', $this->schema) . "\n");
    }
    /**
     * @Given recipes
     */
    public function recipes(TableNode $table)
    {
        $this->writeHeaders();

        $handle = fopen($this->csvPath, 'a+');

        foreach ($table as $recipe) {
            fputcsv($handle, $recipe);
            $this->writtenRecipes[$recipe['id']] = $recipe;
        }
        fclose($handle);
    }

    /**
     * @Given recipe
     */
    public function recipe(TableNode $table)
    {
        $this->recipe = Recipe::fromArray($table->getColumnsHash()[0]);
    }

    /**
     * @When I save recipe
     */
    public function iSaveRecipe()
    {
        $this->recipeRepository->save($this->recipe);
    }

    /**
     * @Then recipe is saved
     */
    public function recipeIsSaved()
    {
        Assert::assertEquals(1, $this->recipe->getId());
        Assert::assertTrue($this->recipeRepository->hasSaved($this->recipe));
    }

    /**
     * @When I fetch recipe by id :id
     */
    public function iFetchRecipeById(int $id)
    {
        $this->fetchId = $id;
        $this->fetchedRecipe = $this->recipeRepository->getById($id);
    }

    /**
     * @Then the recipe is fetched
     */
    public function theRecipeIsFetched()
    {
        Assert::assertEquals($this->writtenRecipes[$this->fetchId]['slug'], $this->fetchedRecipe->getSlug());
    }

    /**
     * @When I fetch recipes by cuisine :cuisine
     */
    public function iFetchRecipesByCuisine(string $cuisine)
    {
        $this->fetchedRecipes = $this->recipeRepository->getByCuisine($cuisine);
    }

    /**
     * @Then recipes are fetched
     */
    public function recipesAreFetched(TableNode $table)
    {
        foreach ($table as $recipe) {
            Assert::assertTrue(array_key_exists($recipe['id'], $this->fetchedRecipes));
        }
    }

}
