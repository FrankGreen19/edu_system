<?php


namespace App\Format\ResponseFormat\UserResponseFormat;


use App\Resource\ResourceInterface;

class OneUserResponseFormat
{
    public function __construct(public ResourceInterface $userResource)
    {
    }
}