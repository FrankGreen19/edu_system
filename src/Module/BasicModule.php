<?php


namespace App\Module;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BasicModule
{
    protected ManagerRegistry $registry;
    protected ValidatorInterface $validator;

    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        $this->registry = $registry;
        $this->validator = $validator;
    }
}