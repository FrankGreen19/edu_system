<?php

namespace App\Controller;

use App\Module\BasicModule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BasicController extends AbstractController
{
    protected ValidatorInterface $validator;
    protected SerializerInterface $serializer;
    protected BasicModule $module;

    public function __construct(ValidatorInterface $validator,
                                SerializerInterface $serializer, BasicModule $module)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->module = $module;
    }
}