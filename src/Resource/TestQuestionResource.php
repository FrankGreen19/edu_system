<?php


namespace App\Resource;


class TestQuestionResource implements ResourceInterface
{
    public int $id;
    public int $testId;
    public int $questionId;
    public int $sortOrder;

    public function __construct(int $id, int $testId, int $questionId, int $sortOrder)
    {
        $this->id = $id;
        $this->testId = $testId;
        $this->questionId = $questionId;
        $this->sortOrder = $sortOrder;
    }
}