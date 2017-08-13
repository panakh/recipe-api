<?php

namespace SDK;

use GuzzleHttp\Client;
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

    public function createRecipe(string $title, string $marketingDescription): ResponseInterface
    {
        $response = $this->client->post('/recipes', [
            'json' => [
                'title' => $title,
                'marketingDescription' => $marketingDescription
            ]
        ]);

        return $response;
    }
}
