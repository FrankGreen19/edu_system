<?php

namespace App\Controller;

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
            'user' => $this->getUser()->toResource(),
        ]);
    }
}
