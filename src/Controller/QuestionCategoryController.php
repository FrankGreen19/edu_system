<?php

namespace App\Controller;

use App\Entity\QuestionCategory;
use App\Format\RequestFormat\QuestionCategoryRequestFormat\NewQuestionCategory;
use App\Format\ResponseFormat\QuestionCategoryResponseFormat\QuestionCategoryListResponseFormat;
use App\Module\QuestionCategoryModule;
use App\Module\UserModule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $cats = $this->module->getCategories(QuestionCategory::AUTHORLESS);
        $catResources = [];

        foreach ($cats as $cat) {
            $catResources[] = $cat->toResource();
        }

        return $this->json(new QuestionCategoryListResponseFormat($catResources));
    }

    #[Route('/authored', methods: [Request::METHOD_GET])]
    public function getAuthoredCategories(): JsonResponse
    {
        $cats = $this->module->getCategories($this->getUser());
        $catResources = [];

        foreach ($cats as $cat) {
            $catResources[] = $cat->toResource();
        }

        return $this->json(new QuestionCategoryListResponseFormat($catResources));
    }

    #[Route(methods: [Request::METHOD_POST])]
    public function addQuestionCategory(Request $request): JsonResponse
    {
        $requestFormat = $this->serializer->deserialize($request->getContent(), NewQuestionCategory::class, 'json');
        $errors = $this->validator->validate($requestFormat);
        if ($errors->count() > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $cat = $this->module->addCategory($requestFormat, $this->getUser());

        if ($cat instanceof QuestionCategory) {
            return $this->json(['questionCategoryResource' => $cat->toResource()]);
        } else {
            return $this->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
