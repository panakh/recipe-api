<?php

namespace spec\SDK;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use SDK\RecipeClient;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeClientSpec extends ObjectBehavior
{
    function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RecipeClient::class);
    }

    function it_creates_recipe(Client $client, ResponseInterface $response)
    {
        $recipe = [
            'title' => 'asian curry',
            'marketingDescription' => 'curry description'
        ];
        $client->post('/recipes', [
            'json' => $recipe
        ])->shouldBeCalled()->willReturn($response);
        $this->createRecipe($recipe);
    }
}
