<?php

namespace spec\Infrastructure;

use Infrastructure\RecipeMobileTransformer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeMobileTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RecipeMobileTransformer::class);
    }
}
