<?php


namespace App\Entity;


class BasicEntity
{
    private array $errors;

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function setError(string $error): void
    {
        $this->errors[] = $error;
    }
}