<?php

namespace Infrastructure;

use Gousto\Recipe;
use League\Fractal\TransformerAbstract;

class RecipeMobileTransformer extends TransformerAbstract
{
    public function transform(Recipe $recipe)
    {
        return [
            'id' => $recipe->getId(),
            'createdAt' => $recipe->getCreatedAt()->format('d/m/Y H:i:s'),
            'updatedAt' => $recipe->getUpdatedAt()->format('d/m/Y H:i:s'),
            'boxType' => $recipe->getBoxType(),
            'title' => $recipe->getTitle(),
            'slug' => $recipe->getSlug(),
            'shortTitle' => $recipe->getShortTitle(),
            'marketingDescription' => $recipe->getMarketingDescription(),
            'calories' => $recipe->getCalories(),
            'protein' => $recipe->getProtein(),
            'fat' => $recipe->getFat(),
            'carbs' => $recipe->getCarbs(),
            'bulletPoint1' => $recipe->getBulletPoint1(),
            'bulletPoint2' => $recipe->getBulletPoint2(),
            'bulletPoint3' => $recipe->getBulletPoint3(),
            'dietTypeId' => $recipe->getDietTypeId(),
            'season' => $recipe->getSeason(),
            'base' => $recipe->getBase(),
            'proteinSource' => $recipe->getProteinSource(),
            'preparationTime' => $recipe->getPreparationTime(),
            'shelfLife' => $recipe->getShelfLife(),
            'equipmentNeeded' => $recipe->getEquipmentNeeded(),
            'originCountry' => $recipe->getOriginCountry(),
            'cuisine' => $recipe->getCuisine(),
            'inYourBox' => $recipe->getInYourBox(),
            'goustoReference' => $recipe->getGoustoReference(),
            'rating' => $recipe->getRating()
        ];

    }
}
