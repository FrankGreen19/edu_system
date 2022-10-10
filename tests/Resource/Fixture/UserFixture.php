<?php


namespace App\Tests\Resource\Fixture;


use App\Entity\Group;
use App\Entity\Role;
use App\Entity\User;
use App\Tests\Tools\FakerTool;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    use FakerTool;

    public function load(ObjectManager $manager)
    {
        $groups = [];
        for ($i = 0; $i <= 2; $i++) {
            $group = new Group();
            $group->setTitle($this->getFaker()->numerify());

            $manager->persist($group);
            $manager->flush();
            
            $groups[] = $group;
        }
        
        $rolePupil = new Role();
        $rolePupil->setTitle('ROLE_PUPIL');
        $manager->persist($rolePupil);

        $roleTeacher = new Role();
        $roleTeacher->setTitle('ROLE_TEACHER');
        $manager->persist($roleTeacher);
        
        $manager->flush();
        
        foreach ($groups as $group) {
            for ($i = 0; $i <= 7; $i++) {
                $user = new User();
                $user->setEmail($this->getFaker()->email());
                $user->setPassword($this->getFaker()->password());
                $user->setLastName($this->getFaker()->lastName());
                $user->setFirstName($this->getFaker()->firstName());
                $user->setActive(User::ACTIVE_YES);
                $user->addRelatedGroup($group);
                $user->addRole($rolePupil);

                $manager->persist($user);
                $manager->flush(); 
            }

            $user = new User();
            $user->setEmail($this->getFaker()->email());
            $user->setPassword($this->getFaker()->password());
            $user->setLastName($this->getFaker()->lastName());
            $user->setFirstName($this->getFaker()->firstName());
            $user->setActive(User::ACTIVE_YES);
            $user->addRelatedGroup($group);
            $user->addRole($roleTeacher);

            $manager->persist($user);
            $manager->flush();
        }
    }
}