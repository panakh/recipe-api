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
class CSVAccessContext implements Context
{
    /**
     * @var string
     */
    private $csvPath;
    private $csvAccess;
    private $exists = false;

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
        $this->csvAccess = new RecipeCSVAccess($this->csvPath);
    }

    /**
     * @AfterScenario
     */
    public function cleanFile()
    {
        file_put_contents($this->csvPath, '');
    }

    /**
     * @Given CSV content
     */
    public function csvContent(PyStringNode $content)
    {
        file_put_contents($this->csvPath, $content, FILE_APPEND);
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
     * @When I check if the recipe :title exists
     * @param string $title
     */
    public function iCheckIfTheRecipeExists(string $title)
    {
        $this->exists = $this->csvAccess->recipeExists($title);
    }

    /**
     * @Then the recipe is found
     */
    public function theRecipeIsFound()
    {
        Assert::assertTrue($this->exists);
    }
}
