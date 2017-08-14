<?php

namespace SDK;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

class RecipeClient
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createRecipe(array $recipe): ResponseInterface
    {

        $response = $this->client->post('/index_dev.php/recipes', [
            'json' => $recipe
        ]);

        return $response;
    }

    public function getRecipe(int $id)
    {
        $response = $this->client->get('/index_dev.php/recipes/'.$id);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getRecipes(array $filters)
    {
        $response = $this->client->get('/index_dev.php/recipes?'.http_build_query($filters));

        return json_decode($response->getBody()->getContents(), true);
    }

    public function rateRecipe(int $recipeId, int $rating)
    {
        $response = $this->client->patch('/index_dev.php/recipes/'.$recipeId, [
            'json' => [
                'rating' => $rating
            ]
        ]);

        return $response;
    }

}
