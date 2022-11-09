<?php

namespace App\Controller;

use App\Format\RequestFormat\QuestionRequestFormat\QuestionRequestFormat;
use App\Format\ResponseFormat\QuestionResponseFormat\QuestionArrayResponseFormat;
use App\Module\QuestionModule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api')]
class QuestionController extends BasicController
{
    private QuestionModule $module;

    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer, QuestionModule $module)
    {
        parent::__construct($validator, $serializer);
        $this->module = $module;
    }

    #[Route('/question', methods: [Request::METHOD_POST])]
    public function getQuestions(Request $request): JsonResponse
    {
        /** @var QuestionRequestFormat $requestFormat */
        $requestFormat = $this->serializer->deserialize($request->getContent(), QuestionRequestFormat::class,
            'json');
        $errors = $this->validator->validate($requestFormat);
        if ($errors->count() > 0) {
            return $this->json([], Response::HTTP_BAD_REQUEST);
        }

        $questions = $this->module->getQuestionsByCategory($requestFormat->questionCategoryId);
        $questionResources = [];

        foreach ($questions as $question) {
            $questionResources[] = $question->toResource();
        }

        return $this->json(new QuestionArrayResponseFormat($questionResources));
    }
}
