<?php


namespace App\Module;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserModule extends BasicModule
{
    private UserRepository $userRepository;

    #[Pure]
    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator,
                                UserRepository $userRepository)
    {
        parent::__construct($registry, $validator);
        $this->userRepository = $userRepository;
    }

    public function getAppUser(string $email): User | null
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }
}