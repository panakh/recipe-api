<?php

namespace spec\SDK;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
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
        $client->post('/index_dev.php/recipes', [
            'json' => $recipe
        ])->shouldBeCalled()->willReturn($response);
        $this->createRecipe($recipe);
    }

    function it_gets_recipe(Client $client, ResponseInterface $response, StreamInterface $contents)
    {
        $response->getBody()->willReturn($contents);
        $client->get('/index_dev.php/recipes/1')->shouldBeCalled()->willReturn($response);
        $this->getRecipe(1);
    }

    function it_gets_recipes_by_cuisine(Client $client, ResponseInterface $response, StreamInterface $contents)
    {
        $response->getBody()->willReturn($contents);
        $client->get('/index_dev.php/recipes?cuisine='.urlencode('asian'))->shouldBeCalled()->willReturn($response);
        $this->getRecipes(['cuisine' => 'asian']);
    }

    function it_can_rate_recipe(Client $client, ResponseInterface $response)
    {
        $recipe = [
            'rating' => 3
        ];

        $client->patch('/index_dev.php/recipes/1',[
              'json' => $recipe
        ])->shouldBeCalled()->willReturn($response);

        $this->rateRecipe(1, 3);
    }

    function it_can_update_recipe(Client $client, ResponseInterface $response)
    {
        $recipe = [
            'rating' => 3
        ];

        $client->patch('/index_dev.php/recipes/1',[
            'json' => $recipe
        ])->shouldBeCalled()->willReturn($response);

        $this->updateRecipe(1, $recipe);
    }
}
