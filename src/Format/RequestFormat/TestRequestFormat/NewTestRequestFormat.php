<?php


namespace App\Format\RequestFormat\TestRequestFormat;


use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewTestRequestFormat
{
    #[NotBlank]
    #[Length(max: 200)]
    public ?string $title = null;

    #[NotBlank]
    #[LessThan(value: 1000)]
    public ?int $questionsNumber = null;

    #[Date]
    public ?string $finishDate = null;

    #[NotBlank]
    #[LessThan(value: 1000)]
    public ?int $executionTime = null;

    #[NotBlank]
    public ?int $testTypeId = null;

    #[NotBlank]
    public ?array $questions;

    #[NotBlank]
    public ?int $questionCategoryId = null;

    public function __construct(?string $title, ?int $questionsNumber,
                                ?string $finishDate, ?int $executionTime, ?int $testTypeId,
                                ?array $questions, ?int $questionCategoryId)
    {
        $this->title = $title;
        $this->questionsNumber = intval($questionsNumber);
        $this->finishDate = $finishDate;
        $this->executionTime = intval($executionTime);
        $this->testTypeId = $testTypeId;
        $this->questions = $questions;
        $this->questionCategoryId = $questionCategoryId;
    }
}
