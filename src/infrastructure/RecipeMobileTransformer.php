<?php

namespace Infrastructure;

use Gousto\Recipe;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class RecipeMobileTransformer extends TransformerAbstract
{
    public function transform(Recipe $recipe)
    {
        $data = $recipe->getRepresentationData();
        return $data;
    }
}
