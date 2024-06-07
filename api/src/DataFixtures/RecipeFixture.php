<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Ingredients;
use App\Entity\Measurement;
use App\Entity\Recipe;
use App\Entity\RecipeIngredients;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecipeFixture extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
            UserFixture::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $json = file_get_contents('src/DataFixtures/data/recipes.json');
        $recipesData = json_decode($json, true);

        foreach ($recipesData as $recipeData) {
            $recipe = new Recipe();

            $recipe
                ->setTitle($recipeData['title'])
                ->setContent($recipeData['content'])
                ->setPreparationTime($recipeData['preparationTime'])
                ->setPortions($recipeData['portions'])
                ->setUser(
                    $manager->getRepository(User::class)->findOneBy(['email' => $recipeData['user']])
                )
                ->setCategory(
                    $manager->getRepository(Category::class)->find($recipeData['category_id'])
                )
            ;

            foreach ($recipeData['ingredients'][0] as $ingredientData) {
                $measurement = $manager->getRepository(Measurement::class)->find($ingredientData['measurement']['id']);

                if (!$measurement) {
                    $measurement = new Measurement();

                    $measurement->setTitle($ingredientData['measurement']['title']);

                    $manager->persist($measurement);
                }

                $ingredient = $manager->getRepository(Ingredients::class)->find($ingredientData['ingredient']['id']);

                if (!$ingredient) {
                    $ingredient = new Ingredients();

                    $ingredient
                        ->setTitle($ingredientData['ingredient']['title'])
                        ->setMeasurement($measurement);

                    $manager->persist($ingredient);
                }

                $recipeIngredient = new RecipeIngredients();

                $recipeIngredient
                    ->setRecipe($recipe)
                    ->setIngredient($ingredient)
                    ->setQuantity($ingredientData['quantity']);

                $manager->persist($recipeIngredient);
            }

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}