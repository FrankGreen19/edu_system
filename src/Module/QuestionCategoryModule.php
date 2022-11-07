<?php


namespace App\Module;


use App\Entity\EntityInterface;
use App\Entity\QuestionCategory;
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
     * @return EntityInterface[]
     */
    public function getCategories($author): array
    {
        return $this->questionCategoryRepository->findBy(['author' => $author]);
    }
}