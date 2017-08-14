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

    public function getRecipe(int $id)
    {
        $response = $this->client->get('/recipes/'.$id);

        return json_decode($response->getBody()->getContents(), true);
    }
}
