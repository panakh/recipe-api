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
    private $title;
    private $marketingDescription;
    private $recipeClient;


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
    }

    /**
     * @Given title :title
     * @param string $title
     */
    public function title(string $title)
    {
        $this->title = $title;
    }

    /**
     * @Given marketing description :marketingDescription
     * @param string $marketingDescription
     */
    public function marketingDescription(string $marketingDescription)
    {
        $this->marketingDescription = $marketingDescription;
    }

    /**
     * @When I create a recipe
     */
    public function iCreateARecipe()
    {
        $this->recipeClient->createRecipe($this->title, $this->marketingDescription);
    }

    /**
     * @Then the recipe is created
     */
    public function theRecipeIsCreated()
    {
        Assert::assertTrue($this->recipeCSVAccess->recipeExists($this->title()));
    }

}
