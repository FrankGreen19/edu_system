<?php


namespace App\Format\RequestFormat\UserTestRequestFormat;


use Symfony\Component\Validator\Constraints\NotNull;

class ExtendedUserTestRequestFormat extends UserTestRequestFormat
{
    #[NotNull]
    public ?int $id;

    public function __construct(?int $id, ?int $testId, ?int $userId)
    {
        parent::__construct($testId, $userId);
        $this->id = $id;
    }
}