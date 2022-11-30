<?php


namespace App\Format\RequestFormat\UserQuestionAnswerRequestFormat;


use Symfony\Component\Validator\Constraints\NotNull;

class AddQuestionAnswerRequestFormat
{
    #[NotNull]
    public ?int $userTestId;

    #[NotNull]
    public ?int $questionId;

    #[NotNull]
    public ?string $answer;

    public function __construct(?int $userTestId, ?int $questionId, ?string $answer)
    {
        $this->userTestId = $userTestId;
        $this->questionId = $questionId;
        $this->answer = $answer;
    }


}