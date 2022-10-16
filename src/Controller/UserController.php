<?php

namespace App\Controller;

use App\Format\ResponseFormat\UserResponseFormat\OneUserResponseFormat;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user')]
class UserController extends AuthenticatedController
{
    #[Route(methods: [Request::METHOD_GET])]
    public function getOne(): JsonResponse
    {
        return $this->json([
            'user' => new OneUserResponseFormat($this->getUser()->toResource()),
        ]);
    }
}
