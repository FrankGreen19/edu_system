<?php


namespace App\Tests\Tools;


use Faker\Factory;
use Faker\Generator;

trait FakerTool
{
    public function getFaker(): Generator
    {
        return Factory::create();
    }
}