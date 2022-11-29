<?php


namespace App\Module;


use App\Entity\Question;
use App\Entity\QuestionCategory;
use App\Entity\User;
use App\Format\RequestFormat\QuestionCategoryRequestFormat\NewQuestionCategory;
use App\Repository\QuestionCategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionCategoryModule extends BasicModule
{
    private QuestionCategoryRepository $questionCategoryRepository;

    #[Pure]
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,
                                QuestionCategoryRepository $questionCategoryRepository)
    {
        parent::__construct($registry, $validator);
        $this->questionCategoryRepository = $questionCategoryRepository;
    }


    /**
     * @return QuestionCategory[]|null
     */
    public function getCategories($author): ?array
    {
        return $this->questionCategoryRepository->findBy(['author' => $author]);
    }

    public function addCategory(NewQuestionCategory $format, User $author): ?QuestionCategory
    {
        $cat = new QuestionCategory();
        $cat->setTitle($format->title);
        $cat->setAuthor($author);

        foreach ($format->questions as $question) {
            $catQuestion = new Question();
            $catQuestion->setDescription($question['description']);
            $catQuestion->setAnswer($question['answer']);

            $cat->addQuestion($catQuestion);
        }

        $em = $this->registry->getManager();
        $em->persist($cat);
        $em->flush();

        if ($cat->getId()) {
            return $cat;
        } else {
            return null;
        }
    }
}