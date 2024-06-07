<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user
            ->setName('Test User')
            ->setEmail('user@gmail.com')
            ->setPassword(password_hash('user80085', PASSWORD_DEFAULT));

        $manager->persist($user);
        $manager->flush();
    }
}