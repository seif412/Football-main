<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setName('Admin');
        $user->setPassword('scsc1234$$');
        $user->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user);


        $manager->flush();
    }
}
