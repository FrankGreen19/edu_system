<?php


namespace App\Format\ResponseFormat;


class ErrorResponseFormat
{
    public function __construct(private string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}