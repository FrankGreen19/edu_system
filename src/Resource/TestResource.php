<?php


namespace App\Resource;


class TestResource implements ResourceInterface
{
    public int $id;
    public ?string $title = null;
    public ?int $questionsNumber = null;
    public ?string $finishDate = null;
    public ?int $executionTime = null;
    public ?TestTypeResource $testType = null;
    public ?array $questions;
    public ?QuestionCategoryResource $questionCategory = null;
    public string $code;

    public function __construct(int $id, ?string $title, ?int $questionsNumber,
                                ?string $finishDate, ?string $executionTime, ?ResourceInterface $testType,
                                ?array $questions, ?ResourceInterface $questionCategory, string $code)
    {
        $this->id = $id;
        $this->title = $title;
        $this->questionsNumber = $questionsNumber;
        $this->finishDate = $finishDate;
        $this->executionTime = intval($executionTime);
        $this->testType = $testType;
        $this->questions = $questions;
        $this->questionCategory = $questionCategory;
        $this->code = $code;
    }
}