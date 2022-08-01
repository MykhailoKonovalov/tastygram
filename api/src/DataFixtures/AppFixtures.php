<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    private Faker\Generator $faker;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->faker          = Faker\Factory::create();
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadAdmin($manager);
        $this->loadUsers($manager);
        $this->loadCategories($manager);
        $this->loadRecipes($manager);
        $this->loadComments($manager);
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function loadUsers(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 25; $i++) {
            $user = new User();

            $user->setName($this->faker->name);
            $user->setPhone($this->faker->phoneNumber);
            $user->setEmail($this->faker->email);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $this->faker->text('8')
            ));

            $this->setReference("user_$i", $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function loadAdmin(ObjectManager $manager): void
    {
        $user = new User();

        $user->setEmail('admin@gmail.com');
        $user->setPhone('+380123456789');
        $user->setName('Admin User');
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            'admin228'
        ));

        $this->setReference('admin', $user);

        $manager->persist($user);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function loadCategories(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $category = new Category();

            $category->setTitle($this->faker->realText('25'));

            $this->setReference("category_$i", $category);

            $manager->persist($category);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function loadRecipes(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $recipe     = new Recipe();
            $userId     = rand(1, 25);
            $categoryId = rand(1, 20);

            $recipe->setTitle($this->faker->realText('50'));
            $recipe->setContent($this->faker->realText());
            $recipe->setAuthor($this->getReference("user_$userId"));
            $recipe->addCategory($this->getReference("category_$categoryId"));

            $this->setReference("recipe_$i", $recipe);

            $manager->persist($recipe);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function loadComments(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 100; $i++) {
            for ($j = 1; $j <= rand(0, 10); $j++){
                $comment = new Comment();
                $userId  = rand(1, 25);

                $comment->setContent($this->faker->text());
                $comment->setAuthor($this->getReference("user_$userId"));
                $comment->setRecipe($this->getReference("recipe_$i"));

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
