<?php


namespace App\Module;


use App\Entity\TestQuestion;
use App\Entity\Test;
use App\Entity\User;
use App\Format\RequestFormat\TestRequestFormat\NewTestRequestFormat;
use App\Repository\QuestionCategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\TestRepository;
use App\Repository\TestTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestModule extends BasicModule
{
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,
                                private TestRepository $testRepository,
                                private TestTypeRepository $testTypeRepository,
                                private QuestionRepository $questionRepository,
                                private QuestionCategoryRepository $questionCategoryRepository
    )
    {
        parent::__construct($registry, $validator);
    }

    public function addTest(NewTestRequestFormat $reqFormat, User $user): ?Test
    {
        $test = new Test();
        $test->setTitle($reqFormat->title);
        $test->setAuthor($user);
        $test->setQuestionsNumber($reqFormat->questionsNumber);
        $test->setQuestionCategory($this->questionCategoryRepository->find($reqFormat->questionCategoryId));
        $test->setCreateDate(new \DateTime());
        $test->setFinishDate(new \DateTime($reqFormat->finishDate));
        $test->setExecutionTime($reqFormat->executionTime);
        $test->setTestType($this->testTypeRepository->find($reqFormat->testTypeId));

        $counter = 1;
        foreach ($reqFormat->questions as $question) {
            $testQuestion = new TestQuestion();
            $testQuestion->setSortOrder($counter);
            $testQuestion->setTest($test);

            if (is_array($question)) {
                $questionId = $question['id'];
            } else {
                $questionId = $question;
            }

            $testQuestion->setQuestion($this->questionRepository->find($questionId));

            $test->addTestQuestion($testQuestion);
            ++$counter;
        }

        $em = $this->registry->getManager();
        $em->persist($test);
        $em->flush();

        if ($test->getId()) {
            return $test;
        } else {
            return null;
        }
    }
}