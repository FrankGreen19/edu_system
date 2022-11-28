<?php


namespace App\Resource;


class QuestionResource implements ResourceInterface
{
    public function __construct(public ?int $id, public ?string $description, public ?string $answer)
    {
    }
}