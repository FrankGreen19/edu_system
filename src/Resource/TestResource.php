<?php


namespace App\Resource;


class TestResource implements ResourceInterface
{
    public int $id;
    public ?string $title = null;
    public ?int $questionsNumber = null;
    public ?string $finishDate = null;
    public ?int $executionTime = null;
    public ?int $testTypeId = null;
    public ?array $questions;
    public ?int $questionCategoryId = null;

    public function __construct(int $id, ?string $title, ?int $questionsNumber,
                                ?string $finishDate, ?string $executionTime, ?int $testTypeId,
                                ?array $questions, ?int $questionCategoryId)
    {
        $this->id = $id;
        $this->title = $title;
        $this->questionsNumber = $questionsNumber;
        $this->finishDate = $finishDate;
        $this->executionTime = intval($executionTime);
        $this->testTypeId = $testTypeId;
        $this->questions = $questions;
        $this->questionCategoryId = $questionCategoryId;
    }
}