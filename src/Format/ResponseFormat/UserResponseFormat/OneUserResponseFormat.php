<?php


namespace App\Format\ResponseFormat\UserResponseFormat;


use App\Resource\UserResource;

class OneUserResponseFormat
{
    public function __construct(public UserResource $userResource)
    {
    }
}