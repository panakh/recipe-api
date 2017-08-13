<?php

namespace spec\SDK;

use GuzzleHttp\Client;
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

    function it_creates_recipe()
    {
        $title = 'title';
        $marketingDescription = 'marketing description';
        $this->createRecipe($title, $marketingDescription);
    }
}
