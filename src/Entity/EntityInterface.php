<?php


namespace App\Entity;


use App\Resource\ResourceInterface;

interface EntityInterface
{
    public function toResource(): ResourceInterface;
}