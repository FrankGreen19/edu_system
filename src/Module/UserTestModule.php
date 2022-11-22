<?php


namespace App\Module;


use App\Entity\User;
use App\Entity\UserTest;
use App\Format\RequestFormat\UserTestRequestFormat\UserTestRequestFormat;
use App\Repository\TestRepository;
use App\Repository\UserTestRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTestModule extends BasicModule
{
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,
                                private UserTestRepository $userTestRepository,
                                private TestRepository $testRepository,
    )
    {
        parent::__construct($registry, $validator);

    }

    public function addUserTest(UserTestRequestFormat $format, User $user): ?UserTest
    {
        $userTest = new UserTest();
        $userTest->setUser($user);
        $userTest->setTest($this->testRepository->find($format->testId));
        $userTest->setStartedAt(new \DateTimeImmutable());

        $em = $this->registry->getManager();
        $em->persist($userTest);
        $em->flush();

        if ($userTest->getId()) {
            return $userTest;
        } else {
            return null;
        }
    }
}