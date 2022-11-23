<?php

namespace App\Controller;

use App\Entity\UserQuestionAnswer;
use App\Format\RequestFormat\UserQuestionAnswerRequestFormat\AddQuestionAnswerRequestFormat;
use App\Format\RequestFormat\UserTestRequestFormat\UserTestRequestFormat;
use App\Module\UserQuestionAnswerModule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/user/question/answer')]
class UserQuestionAnswerController extends BasicController
{
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer,
                                private UserQuestionAnswerModule $module)
    {
        parent::__construct($validator, $serializer);
    }

    #[Route(methods: Request::METHOD_POST)]
    public function addAnswer(Request $request): JsonResponse
    {
        $requestFormat = $this->serializer->deserialize($request->getContent(), AddQuestionAnswerRequestFormat::class, 'json');
        $errors = $this->validator->validate($requestFormat);
        if ($errors->count() > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $answer = $this->module->addNewAnswer($requestFormat);
        if ($answer instanceof UserQuestionAnswer) {
            return $this->json($answer->toResource());
        } else {
            return $this->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
