<?php


namespace App\Service;


use App\Exception\ExceptionFormat;

class ExceptionMappingResolverService
{
    private array $mappings;

    public function __construct(array $mappings)
    {
        foreach ($mappings as $class => $mapping) {
            $this->addMapping($class, $mapping['code'], $mapping['hidden'], $mapping['loggable']);
        }
    }

    public function resolve(string $throwableClass): ?ExceptionFormat
    {
        $foundMapping = null;

        foreach ($this->mappings as $class => $mapping) {
            if ($throwableClass === $class || is_subclass_of($throwableClass, $class)) {
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