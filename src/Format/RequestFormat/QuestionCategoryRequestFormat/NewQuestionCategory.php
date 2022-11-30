<?php


namespace App\Format\RequestFormat\QuestionCategoryRequestFormat;


use Symfony\Component\Validator\Constraints\NotBlank;

class NewQuestionCategory
{
    #[NotBlank]
    public ?string $title;

    #[NotBlank]
    public ?array $questions;

    public function __construct(string $title, ?array $questions)
    {
        $this->title = $title;
        $this->questions = $questions;
    }
}
