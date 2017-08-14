<?php

namespace Gousto;

class RecipeRepository
{
    private $csv;
    private $data = [];
    private $schema = [
        'id',
        'created_at',
        'updated_at',
        'box_type',
        'title',
        'slug',
        'short_title',
        'marketing_description',
        'calories_kcal',
        'protein_grams',
        'fat_grams',
        'carbs_grams',
        'bulletpoint1',
        'bulletpoint2',
        'bulletpoint3',
        'recipe_diet_type',
        'season',
        'base',
        'protein_source',
        'preparation_time_minutes',
        'shelf_life_days',
        'equipment_needed',
        'origin_country',
        'recipe_cuisine',
        'in_your_box',
        'gousto_reference'
    ];

    public function __construct(string $csvPath)
    {
        $this->csv = $csvPath;
    }

    public function getById(int $id): Recipe
    {
        $this->readData();
        foreach ($this->data as $datum) {
            if ($datum['id'] == $id) {
                return Recipe::fromStorage($datum);
            }
        }

        return null;
    }

    public function save(Recipe $recipe)
    {
        $this->createHeadersIfEmptyFile();
        $recipe->setId($this->resolveId());
        $dataHandle = fopen(realpath($this->csv), 'a+');
        fputcsv($dataHandle, $recipe->getData());
        fclose($dataHandle);
        $this->data[] = $recipe->getData();
    }

    public function hasSaved(Recipe $recipe)
    {
        foreach ($this->data as $recipeData) {
            if ($recipeData['id'] == $recipe->getId()) {
                return true;
            }
        }

        return false;
    }

    private function resolveId()
    {
        $this->readData();

        if (empty($this->data)) {
            return 1;
        }

        $keys = $this->resolveKeys();

        return max($keys) + 1;
    }

    private function readData()
    {
        $csv = array_map('str_getcsv', file($this->csv));
        $headers = array_shift($csv);
        foreach ($csv as $values) {
            $this->data[] = array_combine($headers, $values);
        }
    }

    private function resolveKeys(): array
    {
        $keys = [];
        foreach ($this->data as $recipe) {
            $keys[] = $recipe['id'];
        }

        return $keys;
    }

    private function createHeadersIfEmptyFile()
    {
        if (empty(file_get_contents($this->csv))) {
            $dataHandle = fopen(realpath($this->csv), 'a+');
            fputcsv($dataHandle, $this->schema);
            fclose($dataHandle);
        }
    }

    public function getByCuisine(string $cuisine): array
    {
        $recipes = [];
        $this->readData();
        foreach ($this->data as $recipeData) {
            if ($recipeData['recipe_cuisine'] == $cuisine) {
                $recipe = Recipe::fromStorage($recipeData);
                $recipes[$recipe->getId()] = $recipe;
            }
        }

        return $recipes;
    }
}
