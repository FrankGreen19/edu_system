<?php


namespace App\Format\RequestFormat\TestRequestFormat;


use Symfony\Component\Validator\Constraints\NotNull;

class ExistingTestRequestFormat extends NewTestRequestFormat
{
    #[NotNull]
    public int $id;

    public function __construct(int $id, ?string $title, ?int $questionsNumber,
                                ?string $finishDate, ?int $executionTime, ?int $testTypeId,
                                ?array $questions, ?int $questionCategoryId)
    {
        parent::__construct($title, $questionsNumber, $finishDate, $executionTime, $testTypeId, $questions, $questionCategoryId);
        $this->id = $id;
    }
}