<?php


namespace App\Module;


use App\Entity\User;
use App\Entity\UserTest;
use App\Exception\NotFoundException;
use App\Format\RequestFormat\UserTestRequestFormat\ExtendedUserTestRequestFormat;
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

    public function updateUserTest(ExtendedUserTestRequestFormat $format): ?UserTest
    {
        $userTest = $this->userTestRepository->find($format->id);
        if (!$userTest) {
            throw new NotFoundException();
        }

        $result = 0;
        foreach ($userTest->getUserQuestionAnswers() as $answer) {
            if ($answer->isCorrect()) {
                $result++;
            }
        }

        $questionNumber = sizeof($userTest->getTest()->getTestQuestions());
        $userTest->setResult(($result * 100) / $questionNumber);

        $em = $this->registry->getManager();
        $em->persist($userTest);
        $em->flush();

        if ($userTest->getId()) {
            return $userTest;
        } else {
            return null;
        }
    }

    /**
     * @param User $user
     * @return ?UserTest[]
     */
    public function getUserTests(User $user): ?array
    {
        return $this->userTestRepository->findBy(['user' => $user]);
    }
}