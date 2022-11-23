<?php


namespace App\Module;


use App\Entity\UserQuestionAnswer;
use App\Format\RequestFormat\UserQuestionAnswerRequestFormat\AddQuestionAnswerRequestFormat;
use App\Repository\QuestionRepository;
use App\Repository\UserQuestionAnswersRepository;
use App\Repository\UserTestRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserQuestionAnswerModule extends BasicModule
{
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,
                                private UserQuestionAnswersRepository $answersRepository, private UserTestRepository $userTestRepository,
                                private QuestionRepository $questionRepository,
    )
    {
        parent::__construct($registry, $validator);
    }

    public function addNewAnswer(AddQuestionAnswerRequestFormat $format): ?UserQuestionAnswer
    {
        $answer = new UserQuestionAnswer();
        $answer->setQuestion($this->questionRepository->find($format->questionId));
        $answer->setUserTest($this->userTestRepository->find($format->userTestId));
        $answer->setAnswer($format->answer);

        $em = $this->registry->getManager();
        $em->persist($answer);
        $em->flush();

        if ($answer->getId()) {
            return $answer;
        } else {
            return null;
        }
    }
}