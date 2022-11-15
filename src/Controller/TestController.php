<?php

namespace App\Controller;

use App\Format\RequestFormat\TestRequestFormat\NewTestRequestFormat;
use App\Format\ResponseFormat\TestResponseFormat\OneTestResponseFormat;
use App\Module\TestModule;
use App\Module\UserModule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/test')]
class TestController extends AuthenticatedController
{
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer,
                                UserModule $userModule, private TestModule $testModule)
    {
        parent::__construct($validator, $serializer, $userModule);
    }

    #[Route(methods: Request::METHOD_POST)]
    public function addTest(Request $request): JsonResponse
    {
        $requestFormat = $this->serializer->deserialize($request->getContent(), NewTestRequestFormat::class, 'json');
        $errors = $this->validator->validate($requestFormat);
        if ($errors->count() > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $test = $this->testModule->addTest($requestFormat, $this->getUser());

        if ($test) {
            return $this->json(new OneTestResponseFormat($test->toResource()));
        } else {
            return $this->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
