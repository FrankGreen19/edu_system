<?php


namespace App\Format\RequestFormat\QuestionCategoryRequestFormat;


use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class NewQuestionCategory
{
    #[NotBlank]
    public string $title;

    #[NotNull]
    public array $questions;

    public function __construct(string $title, array $questions)
    {
        $this->title = $title;
        $this->questions = $questions;
    }
}
