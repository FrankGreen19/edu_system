<?php


namespace App\Format\RequestFormat;


use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationRequestFormat
{
    #[NotBlank]
    public ?string $email = null;

    #[NotBlank]
    public ?string $password = null;

    #[NotBlank]
    public ?string $last_name = null;

    #[NotBlank]
    public ?string $first_name = null;
}