<?php

namespace Gousto;

use DateTime;
use InvalidArgumentException;

class Recipe
{
    private $boxType;
    private $title;
    private $slug;
    private $shortTitle;
    private $calories;
    private $protein;
    private $fat;
    private $carbs;
    private $bulletPoint1;
    private $bulletPoint2;
    private $bulletPoint3;
    private $dietTypeId;
    private $season;
    private $base;
    private $proteinSource;
    private $preparationTime;
    private $shelfLife;
    private $equipmentNeeded;
    private $originCountry;
    private $cuisine;
    private $inYourBox;
    private $goustoReference;
    private $createdAt;
    private $updatedAt;
    private $marketingDescription;
    private $id;

    static $map = [
        'id' => 'id',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt',
        'box_type' => 'boxType',
        'title' => 'title',
        'slug' => 'slug',
        'short_title' => 'shortTitle',
        'marketing_description' => 'marketingDescription',
        'calories_kcal' => 'calories',
        'protein_grams' => 'protein',
        'fat_grams' => 'fat',
        'carbs_grams' => 'carbs',
        'bulletpoint1' => 'bulletPoint1',
        'bulletpoint2' => 'bulletPoint2',
        'bulletpoint3' => 'bulletPoint3',
        'recipe_diet_type_id' => 'dietTypeId',
        'season' => 'season',
        'base' => 'base',
        'protein_source' => 'proteinSource',
        'preparation_time_minutes' => 'preparationTime',
        'shelf_life_days' => 'shelfLife',
        'equipment_needed' => 'equipmentNeeded',
        'origin_country' => 'originCountry',
        'recipe_cuisine' => 'cuisine',
        'in_your_box' => 'inYourBox',
        'gousto_reference' => 'goustoReference',
        'rating' => 'rating'
    ];

    private $rating;

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new DateTime();
    }

    public static function fromStorage(array $data)
    {
        $recipe = new static();
        foreach ($data as $key => $value) {

            $property = static::$map[$key];
            $setter = 'set'.lcfirst($property);
            $recipe->$setter($value);
        }

        return $recipe;
    }

    public static function fromRepresentation(array $data)
    {
        $recipe = new static();
        foreach ($data as $key => $value) {
            $setter = 'set'.lcfirst($key);
            $recipe->$setter($value);
        }

        return $recipe;
    }

    public function update(array $data)
    {
        foreach ($data as $key => $value) {
            $setter = 'set'.lcfirst($key);
            $this->$setter($value);
        }

        $this->updatedAt = new DateTime();
    }

    public function setBoxType(string $boxType)
    {
        $this->boxType = $boxType;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        $this->createSlug();
    }

    public function getBoxType()
    {
        return $this->boxType;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    private function createSlug()
    {
        $lowered = strtolower($this->title);
        $hyphened = str_replace(' ','-', $lowered);
        $this->slug = $hyphened;
    }

    public function setShortTitle(string $shortTitle)
    {
        $this->shortTitle = $shortTitle;
    }

    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    public function setCalories(int $calories)
    {
        $this->calories = $calories;
    }

    public function getCalories()
    {
        return $this->calories;
    }

    public function setProtein(int $grams)
    {
        $this->protein = $grams;
    }

    public function getProtein()
    {
        return $this->protein;
    }

    public function setFat(int $grams)
    {
        $this->fat = $grams;
    }

    public function getFat()
    {
        return $this->fat;
    }

    public function setCarbs(int $grams)
    {
        $this->carbs = $grams;
    }

    public function getCarbs()
    {
        return $this->carbs;
    }

    public function setBulletPoint1(string $bulletPoint)
    {
        $this->bulletPoint1 = $bulletPoint;
    }

    public function getBulletPoint1()
    {
        return $this->bulletPoint1;
    }

    public function setBulletPoint2(string $bulletPoint)
    {
        $this->bulletPoint2 = $bulletPoint;
    }

    public function getBulletPoint2()
    {
        return $this->bulletPoint2;
    }

    public function setBulletPoint3(string $bulletPoint)
    {
        $this->bulletPoint3 = $bulletPoint;
    }

    public function getBulletPoint3()
    {
        return $this->bulletPoint3;
    }

    public function setDietTypeId(string $dietTypeId)
    {
        $this->dietTypeId = $dietTypeId;
    }

    public function getDietTypeId()
    {
        return $this->dietTypeId;
    }

    public function setSeason(string $season)
    {
        $this->season = $season;
    }

    public function getSeason()
    {
        return $this->season;
    }

    public function setBase(string $base)
    {
        $this->base = $base;
    }

    public function getBase()
    {
        return $this->base;
    }

    public function setProteinSource(string $source)
    {
        $this->proteinSource = $source;
    }

    public function getProteinSource()
    {
        return $this->proteinSource;
    }

    public function setPreparationTime(int $minutes)
    {
        $this->preparationTime = $minutes;
    }

    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    public function setShelfLife(int $days)
    {
        $this->shelfLife = $days;
    }

    public function getShelfLife()
    {
        return $this->shelfLife;
    }

    public function setEquipmentNeeded(string $equipment)
    {
        $this->equipmentNeeded = $equipment;
    }

    public function getEquipmentNeeded(): string
    {
        return $this->equipmentNeeded;
    }

    public function setOriginCountry(string $country)
    {
        $this->originCountry = $country;
    }

    public function getOriginCountry(): string
    {
        return $this->originCountry;
    }

    public function setCuisine(string $cuisine)
    {
        $this->cuisine = $cuisine;
    }

    public function getCuisine()
    {
        return $this->cuisine;
    }

    public function setInYourBox(string $inYourBox)
    {
        $this->inYourBox = $inYourBox;
    }

    public function getInYourBox()
    {
        return $this->inYourBox;
    }

    public function setGoustoReference(int $reference)
    {
        $this->goustoReference = $reference;
    }

    public function getGoustoReference()
    {
        return $this->goustoReference;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($dateTime)
    {
        $updatedAt = null;
        if (is_string($dateTime)) {
            $updatedAt = DateTime::createFromFormat('d/m/Y H:i:s', $dateTime);
        } else if ($dateTime instanceof DateTime) {
            $updatedAt = $dateTime;
        }
        $this->updatedAt = $updatedAt;
    }

    public function getData()
    {
        return [
            'id' => $this->id,
            'created_at' => $this->createdAt->format('d/m/Y H:i:s'),
            'updated_at' => $this->updatedAt->format('d/m/Y H:i:s'),
            'box_type' => $this->boxType,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_title' => $this->shortTitle,
            'marketing_description' => $this->marketingDescription,
            'calories_kcal' => $this->calories,
            'protein_grams' => $this->protein,
            'fat_grams' => $this->fat,
            'carbs_grams' => $this->carbs,
            'bulletpoint1' => $this->bulletPoint1,
            'bulletpoint2' => $this->bulletPoint2,
            'bulletpoint3' => $this->bulletPoint3,
            'recipe_diet_type_id' => $this->dietTypeId,
            'season' => $this->season,
            'base' => $this->base,
            'protein_source' => $this->proteinSource,
            'preparation_time_minutes' => $this->preparationTime,
            'shelf_life_days' => $this->shelfLife,
            'equipment_needed' => $this->equipmentNeeded,
            'origin_country' => $this->originCountry,
            'recipe_cuisine' => $this->cuisine,
            'in_your_box' => $this->inYourBox,
            'gousto_reference' => $this->goustoReference,
            'rating' => $this->rating
        ];
    }

    public function setMarketingDescription(string $description)
    {
        $this->marketingDescription = $description;
    }

    public function getMarketingDescription()
    {
        return $this->marketingDescription;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCreatedAt($dateTime)
    {
        $createdAt = null;
        if (is_string($dateTime)) {
            $createdAt = DateTime::createFromFormat('d/m/Y H:i:s', $dateTime);
        } else if ($dateTime instanceof DateTime) {
            $createdAt = $dateTime;
        }
        $this->createdAt = $createdAt;
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    public function setRating($rating)
    {
        if (empty($rating)) {
            return;
        }

        $rating = (int) $rating;

        if (!($rating >=1 && $rating <= 5)){
            throw new InvalidArgumentException('Rating has to be between 1 and 5');
        }
        $this->rating  = $rating;
    }

    public function getRating()
    {
        return $this->rating;
    }
}