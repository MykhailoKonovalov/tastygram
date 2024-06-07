<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public function __construct(private readonly Connection $connection) {}

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $json = file_get_contents('src/DataFixtures/data/categories.json');
        $categoriesData = json_decode($json, true);

        foreach ($categoriesData as $item) {
            $columns = $values = [];

            foreach ($item as $key => $value) {
                $columns[] = $key;
                $values[] = $this->connection->quote($value);
            }

            $query = sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                'category',
                implode(', ', $columns),
                implode(', ', $values)
            );

            $this->connection->executeQuery($query);
        }
    }
}