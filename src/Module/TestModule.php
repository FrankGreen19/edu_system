<?php


namespace App\Module;


use App\Entity\Test;
use App\Entity\TestQuestion;
use App\Entity\TestType;
use App\Entity\User;
use App\Exception\NotFoundException;
use App\Format\RequestFormat\TestRequestFormat\ExistingTestRequestFormat;
use App\Format\RequestFormat\TestRequestFormat\NewTestRequestFormat;
use App\Repository\QuestionCategoryRepository;
use App\Repository\QuestionRepository;
use App\Repository\TestRepository;
use App\Repository\TestTypeRepository;
use App\Resource\TestResource;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestModule extends BasicModule
{
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,
                                private TestTypeRepository $testTypeRepository,
                                private QuestionRepository $questionRepository,
                                private QuestionCategoryRepository $questionCategoryRepository,
                                private TestRepository $testRepository
    )
    {
        parent::__construct($registry, $validator);
    }

    public function addTest(NewTestRequestFormat $reqFormat, User $user): ?Test
    {
        $test = new Test();
        $test->setTitle($reqFormat->title);
        $test->setAuthor($user);
        $test->setQuestionCategory($this->questionCategoryRepository->find($reqFormat->questionCategoryId));
        $test->setCreateDate(new \DateTime());
        $test->setFinishDate(new \DateTime($reqFormat->finishDate));
        $test->setExecutionTime($reqFormat->executionTime);
        $test->setTestType($this->testTypeRepository->find($reqFormat->testTypeId));
        $test->generateCode();

        $questions = [];
        switch ($test->getTestType()->getAlias()) {
            case TestType::TYPE_CUSTOM:
                $questions = $reqFormat->questions;
                break;
            case TestType::TYPE_GENERATED:
                $test->setQuestionsNumber($reqFormat->questionsNumber);
                $questions = $this->questionRepository->findRandomQuestionsByCategory($test->getQuestionCategory()->getId(),
                    $test->getQuestionsNumber());
                break;
        }

        $counter = 1;
        foreach ($questions as $question) {
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

    public function getTestById(int $id): ?Test
    {
        return $this->testRepository->find($id);
    }

    /**
     * @param User $author
     * @return Test[]
     */
    public function getTestsByAuthor(User $author): array
    {
        $tests = $this->testRepository->findBy(['author' => $author]);
        if (!$tests) {
            throw new NotFoundException();
        }

        return $tests;
    }

    public function getTestByCode(string $code): ?Test
    {
        $test = $this->testRepository->findOneBy(['code' => $code]);
        if (!$test) {
            throw new NotFoundException();
        }

        return $test;
    }

    public function update(ExistingTestRequestFormat $format): ?Test
    {
        $test = $this->testRepository->find($format->id);
        if (!$test) {
            throw new NotFoundException();
        }

        $finishDate = new \DateTime($format->finishDate);

        $test->setExecutionTime($format->executionTime);
        $test->setFinishDate($finishDate);

        $em = $this->registry->getManager();
        $em->persist($test);
        $em->flush();

        if ($test->getExecutionTime() === $format->executionTime
            && $test->getFinishDate() === $finishDate) {
            return $test;
        } else {
            return null;
        }
    }
}