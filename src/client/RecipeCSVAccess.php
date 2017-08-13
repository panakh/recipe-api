<?php

namespace SDK;

class RecipeCSVAccess
{
    /**
     * @var string
     */
    private $csvPath;

    public function __construct(string $csvPath)
    {
        $this->csvPath = $csvPath;
    }

    public function recipeExists(string $title): bool
    {
        $data = $this->readData();
        foreach ($data as $rows) {
            if ($rows['title'] == $title) {
                return true;
            }
        }
        return false;
    }

    private function readData(): array
    {
        $csv = array_map('str_getcsv', file($this->csvPath));
        $headers = array_shift($csv);
        $data = [];

        foreach ($csv as $row) {
            $data[] = array_combine($headers, $row);
        }

        return $data;
    }
}
