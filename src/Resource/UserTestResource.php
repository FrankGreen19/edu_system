<?php


namespace App\Resource;


class UserTestResource implements ResourceInterface
{
    public function __construct(public int $id, public int $userId, public int $testId)
    {
    }
}