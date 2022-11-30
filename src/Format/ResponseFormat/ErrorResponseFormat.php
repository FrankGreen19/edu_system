<?php


namespace App\Format\ResponseFormat;


class ErrorResponseFormat
{
    public function __construct(public string $title, public ?string $propertyPath = null)
    {
    }
}