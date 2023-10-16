<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct (UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder= $passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
        $role1 = new Role();
        $role1->setName("Admin")
            ->setRoleName("ROLE_ADMIN")
            ->setStatus("active");
        $manager->persist($role1);

        $role2 = new Role();
        $role2->setName("User")
            ->setRoleName("ROLE_USER")
            ->setStatus("active");
        $manager->persist($role2);
        //$manager->flush();

        $user1 = new User();
        $user1->setEmail("admin@demo.local")
            ->setFirstname("Administrator")
            ->setLastname("Demo")
            ->setPassword($this->passwordEncoder->encodePassword($user1,"admin123"))
            ->setRole($role1);

        $user1->setStatus("active");
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail("user@demo.local")
            ->setFirstname("User")
            ->setLastname("Demo")
            ->setPassword($this->passwordEncoder->encodePassword($user2,"user1234"))
            ->setRole($role2);
        $user2->setStatus('active');
        $manager->persist($user2);

        $manager->flush();
    }
}
