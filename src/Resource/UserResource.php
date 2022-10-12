<?php


namespace App\Resource;

class UserResource implements ResourceInterface
{
    public ?int $id = null;
    public ?string $email = null;
    public ?string $last_name = null;
    public ?string $first_name = null;
    public ?string $full_name = null;
    public ?int $active = null;
    public array $roles;

    public function __construct(?int $id, ?string $email,
                                ?string $last_name, ?string $first_name, ?string $full_name,
                                ?int $active, array $roles)
    {
        $this->id = $id;
        $this->email = $email;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->full_name = $full_name;
        $this->active = $active;
        $this->roles = $roles;
    }
}