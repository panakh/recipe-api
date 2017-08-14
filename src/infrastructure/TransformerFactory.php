<?php

namespace Infrastructure;

use Gousto\Recipe;

class TransformerFactory
{
    private static $mobileTransformers = [
        Recipe::class => RecipeMobileTransformer::class
    ];
    public function createTransformer(string $accept, string $type)
    {
        if ($accept === 'application/vnd.mobile+json') {
            return new static::$mobileTransformers[$type];
        }
    }
}
