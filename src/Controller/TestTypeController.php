<?php

namespace App\Controller;

use App\Entity\EntityInterface;
use App\Format\ResponseFormat\TestTypeResponseFormat\AllTestTypesResponseFormat;
use App\Module\TestTypeModule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/test-type')]
class TestTypeController extends BasicController
{
    private TestTypeModule $module;

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer, TestTypeModule $module)
    {
        parent::__construct($validator, $serializer);
        $this->module = $module;
    }

    #[Route(methods: [Request::METHOD_GET])]
    public function index(): JsonResponse
    {
        /** @var EntityInterface[] $testTypes */
        $testTypes = $this->module->getTestTypes();
        $resources = [];

        foreach ($testTypes as $testType) {
            $resources[] = $testType->toResource();
        }

        return $this->json(new AllTestTypesResponseFormat($resources));
    }
}
