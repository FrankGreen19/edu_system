<?php

namespace App\Controller;

use App\Entity\UserTest;
use App\Format\RequestFormat\UserTestRequestFormat\ExtendedUserTestRequestFormat;
use App\Format\RequestFormat\UserTestRequestFormat\UserTestRequestFormat;
use App\Module\UserModule;
use App\Module\UserTestModule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/user/test')]
class UserTestController extends AuthenticatedController
{
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer, UserModule $userModule,
                private UserTestModule $module
    )
    {
        parent::__construct($validator, $serializer, $userModule);
    }

    #[Route(methods: Request::METHOD_GET)]
    public function getUserTests(): JsonResponse
    {
        $userTests = $this->module->getUserTests($this->getUser());

        $resources = [];
        foreach ($userTests as $test) {
            $resources[] = $test->toResource();
        }

        return $this->json(['userTestsResources' => $resources]);
    }

    #[Route(methods: Request::METHOD_POST)]
    public function addUserTest(Request $request): JsonResponse
    {
        $requestFormat = $this->serializer->deserialize($request->getContent(), UserTestRequestFormat::class, 'json');
        $errors = $this->validator->validate($requestFormat);
        if ($errors->count() > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $userTest = $this->module->addUserTest($requestFormat, $this->getUser());
        if ($userTest instanceof UserTest) {
            return $this->json(['userTestResource' => $userTest->toResource()]);
        } else {
            return $this->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(methods: Request::METHOD_PUT)]
    public function updateUserTest(Request $request): JsonResponse
    {
        $requestFormat = $this->serializer->deserialize($request->getContent(), ExtendedUserTestRequestFormat::class, 'json');
        $errors = $this->validator->validate($requestFormat);
        if ($errors->count() > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $userTest = $this->module->updateUserTest($requestFormat);
        if ($userTest instanceof UserTest) {
            return $this->json(['userTestResource' => $userTest->toResource()]);
        } else {
            return $this->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
