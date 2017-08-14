<?php

namespace spec\Infrastructure;

use Gousto\Recipe;
use Infrastructure\RecipeMobileTransformer;
use Infrastructure\TransformerFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransformerFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TransformerFactory::class);
    }

    function it_creates_transformer_for_accept_and_type()
    {
        $this->createTransformer('application/vnd.mobile+json', Recipe::class)
            ->shouldBeAnInstanceOf(RecipeMobileTransformer::class);
    }
}
