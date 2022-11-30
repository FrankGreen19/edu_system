<?php


namespace App\Format\RequestFormat\UserTestRequestFormat;


use Symfony\Component\Validator\Constraints\NotNull;

class UserTestRequestFormat
{
    #[NotNull]
    public ?int $testId;

    #[NotNull]
    public ?int $userId;

    public function __construct(?int $testId, ?int $userId)
    {
        $this->userId = $userId;
        $this->testId = $testId;
    }
}