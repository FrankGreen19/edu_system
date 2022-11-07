<?php


namespace App\Resource;


class QuestionCategoryResource implements ResourceInterface
{
    public ?int $id = null;
    public ?string $title = null;

    public function __construct(?int $id, ?string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
}
