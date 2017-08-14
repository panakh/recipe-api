<?php

namespace spec\Gousto;

use Gousto\Recipe;
use Gousto\RecipeRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeRepositorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('csv');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RecipeRepository::class);
    }

    function it_saves_recipe(Recipe $recipe)
    {
        $this->save($recipe);
        $this->shouldHaveSaved($recipe)->shouldBe(true);
    }
}
