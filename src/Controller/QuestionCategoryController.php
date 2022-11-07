<?php

namespace App\Controller;

use App\Format\ResponseFormat\QuestionCategoryResponseFormat\QuestionCategoryListResponseFormat;
use App\Module\QuestionCategoryModule;
use App\Module\UserModule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/question-category')]
class QuestionCategoryController extends AuthenticatedController
{
    private QuestionCategoryModule $module;

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer,
                                UserModule $userModule, QuestionCategoryModule $module)
    {
        parent::__construct($validator, $serializer, $userModule);
        $this->module = $module;
    }

    #[Route('/common', methods: [Request::METHOD_GET])]
    public function getCommonCategories(): JsonResponse
    {
        $cats = $this->module->getCommonCategories();
        $catResources = [];

        foreach ($cats as $cat) {
            $catResources[] = $cat->toResource();
        }

        return $this->json(new QuestionCategoryListResponseFormat($catResources));
    }
}
