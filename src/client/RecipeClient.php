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
        $response = $this->client->post('/recipes', [
            'json' => $recipe
        ]);

        return $response;
    }
}
