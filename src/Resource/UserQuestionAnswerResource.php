<?php


namespace App\Resource;


class UserQuestionAnswerResource implements ResourceInterface
{
    public function __construct(public int $userTestId, public $questionId, public string $answer,
                                public bool $correct, public string $questionDescription)
    {
    }
}