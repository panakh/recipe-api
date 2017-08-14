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
     */
    public function cleanFile()
    {
        file_put_contents($this->csvPath, '');
    }

    /**
     * @Given recipes
     */
    public function recipes(TableNode $table)
    {
        file_put_contents(
            $this->csvPath,
            implode("\n",
                array_map(
                    function($row) {
                        return implode(",", $row);
                    },
                    $table->getRows()
                )
            ),
            FILE_APPEND);
    }

    /**
     * @Given recipe
     */
    public function recipe(TableNode $table)
    {
        $this->recipe = Recipe::fromData($table->getColumnsHash()[0]);
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
}
