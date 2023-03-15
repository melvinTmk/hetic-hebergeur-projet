<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Factory\FileFactory;
use App\Factory\ProjectFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //UserFactory::createMany(10);
        //ProjectFactory::createMany(10);
        FileFactory::createMany(10);
        $manager->flush();
    }
}
