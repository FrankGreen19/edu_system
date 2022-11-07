<?php


namespace App\Format\RequestFormat\QuestionRequestFormat;


use Symfony\Component\Validator\Constraints\NotBlank;

class QuestionRequestFormat
{
    #[NotBlank]
    public ?int $questionCategoryId;
}