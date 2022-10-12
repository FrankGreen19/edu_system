<?php


namespace App\Controller;


use App\Entity\User;
use App\Module\UserModule;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthenticatedController extends BasicController
{
    protected UserModule $userModule;

    #[Pure]
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer, UserModule $userModule)
    {
        parent::__construct($validator, $serializer);

        $this->userModule = $userModule;
    }

    protected function getUser(): ?User
    {
        $userFromToken = parent::getUser();

        return $this->userModule->getAppUser($userFromToken->getUserIdentifier());
    }
}