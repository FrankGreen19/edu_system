<?php


namespace App\Format\ResponseFormat\QuestionResponseFormat;


class QuestionArrayResponseFormat
{
    public function __construct(public ?array $questionResources)
    {
    }
}