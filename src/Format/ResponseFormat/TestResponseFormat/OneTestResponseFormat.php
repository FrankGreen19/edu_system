<?php


namespace App\Format\ResponseFormat\TestResponseFormat;


use App\Resource\ResourceInterface;

class OneTestResponseFormat
{
    public function __construct(public ResourceInterface $testResource)
    {
    }
}