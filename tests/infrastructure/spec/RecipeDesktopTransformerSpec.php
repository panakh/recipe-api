<?php

namespace spec\Infrastructure;

use Infrastructure\RecipeDesktopTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeDesktopTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RecipeDesktopTransformer::class);
    }
}
