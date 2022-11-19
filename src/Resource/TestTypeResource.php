<?php


namespace App\Resource;


class TestTypeResource implements ResourceInterface
{
    public ?int $id = null;
    public ?string $title = null;
    public string $alias;

    public function __construct(int $id, string $title, string $alias)
    {
        $this->id = $id;
        $this->title = $title;
        $this->alias = $alias;
    }
}