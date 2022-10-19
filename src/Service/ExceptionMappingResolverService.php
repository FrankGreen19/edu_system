<?php


namespace App\Service;


use App\Exception\ExceptionFormat;
use Throwable;

class ExceptionMappingResolverService
{
    private array $mappings;

    public function __construct(array $mappings)
    {
        foreach ($mappings as $class => $mapping) {
            $this->addMapping($class, $mapping['code'], $mapping['hidden'], $mapping['loggable']);
        }
    }

    public function resolve(Throwable $throwableClass): ?ExceptionFormat
    {
        $foundMapping = null;

        /** @var ExceptionFormat $mapping */
        foreach ($this->mappings as $class => $mapping) {
            $throwableClassName = get_class($throwableClass);

            if ($throwableClassName === $class
                || is_subclass_of($throwableClassName, $class)
                || $mapping->getCode() === $throwableClass->getCode())
            {
                $foundMapping = $mapping;
                break;
            }
        }

        return $foundMapping;
    }

    private function addMapping(string $className, int $code, bool $hidden = true, bool $loggable = false): void
    {
        $this->mappings[$className] = new ExceptionFormat($code, $hidden, $loggable);
    }
}