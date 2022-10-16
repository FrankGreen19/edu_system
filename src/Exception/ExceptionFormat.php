<?php


namespace App\Exception;


class ExceptionFormat
{
    private int $code;
    private bool $hidden;
    private bool $loggable;

    public function __construct(int $code, bool $hidden, bool $loggable)
    {
        $this->code = $code;
        $this->hidden = $hidden;
        $this->loggable = $loggable;
    }

    public static function createFromCode(int $code): self
    {
        return new self($code, true, false);
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    public function isLoggable(): bool
    {
        return $this->loggable;
    }

    public function setLoggable(bool $loggable): void
    {
        $this->loggable = $loggable;
    }
}