<?php

namespace App\DataFixtures;

use App\Entity\ClassRoom;
use Doctrine\Persistence\ObjectManager;

class ClassRoomFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(ClassRoom::class, 5, function (ClassRoom $classRoom) {
            $classRoom
                ->setClass($this->faker->word)
                ->setCreated($this->faker->dateTime)
                ->setActive($this->faker->boolean);
        });

        $manager->flush();
    }
}
