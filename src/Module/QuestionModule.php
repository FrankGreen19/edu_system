<?php


namespace App\Module;


use App\Entity\EntityInterface;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionModule extends BasicModule
{
    private QuestionRepository $questionRepository;

    #[Pure]
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,
                                QuestionRepository $questionRepository)
    {
        parent::__construct($registry, $validator);
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return EntityInterface[]
     */
    public function getQuestionsByCategory($catId): array
    {
        return $this->questionRepository->findBy(['questionCategory' => $catId]);
    }
}