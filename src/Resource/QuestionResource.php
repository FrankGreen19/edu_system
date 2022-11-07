<?php


namespace App\Resource;


use App\Entity\QuestionCategory;
use App\Entity\QuestionImage;

class QuestionResource implements ResourceInterface
{
    public function __construct(public ?int $id, public ?string $description,
                                public ?string $answer, public ?int $questionCategoryId)
    {
    }
}