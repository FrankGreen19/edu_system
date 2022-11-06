<?php


namespace App\Format\ResponseFormat\TestTypeResponseFormat;


use App\Resource\TestTypeResource;

class AllTestTypesResponseFormat
{
    public function __construct(public array $testTypeResources)
    {
    }
}