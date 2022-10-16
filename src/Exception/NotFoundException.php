<?php


namespace App\Exception;


use JetBrains\PhpStorm\Pure;
use RuntimeException;
use Throwable;

class NotFoundException extends RuntimeException
{
    #[Pure]
    public function __construct()
    {
        parent::__construct('Resource not found');
    }
}