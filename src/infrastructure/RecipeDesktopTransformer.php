<?php

namespace Infrastructure;

use Gousto\Recipe;
use League\Fractal\TransformerAbstract;

class RecipeDesktopTransformer extends TransformerAbstract
{
    public function transform(Recipe $recipe)
    {
        $data = $recipe->getRepresentationData();
        return $data;
    }
}
