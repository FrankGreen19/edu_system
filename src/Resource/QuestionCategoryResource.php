<?php


namespace App\Resource;


class QuestionCategoryResource implements ResourceInterface
{
    public ?int $id = null;
    public ?string $title = null;
    public array $questions;

    public function __construct(?int $id, ?string $title, array $questions)
    {
        $this->id = $id;
        $this->title = $title;
        $this->questions = $questions;
    }
}
