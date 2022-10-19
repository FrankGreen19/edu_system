<?php


namespace App\Listener;


use App\Exception\ExceptionFormat;
use App\Format\ResponseFormat\ErrorResponseFormat;
use App\Service\ExceptionMappingResolverService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ApiExceptionListener
{
    public function __construct(private ExceptionMappingResolverService $mappingService,
                                private LoggerInterface $logger, private SerializerInterface $serializer)
    {
    }

    public function __invoke(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();
        $exception = $this->mappingService->resolve(get_class($throwable));
        if (!$exception) {
            $exception = ExceptionFormat::createFromCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception->getCode() >= Response::HTTP_INTERNAL_SERVER_ERROR || $exception->isLoggable()) {
            $this->logger->error($throwable->getMessage(), [$throwable->getTrace()]);
        }

        $message = $exception->isHidden() ? Response::$statusTexts[$exception->getCode()] : $throwable->getMessage();
        $responseBody = $this->serializer->serialize(new ErrorResponseFormat($message), JsonEncoder::FORMAT);
        $response = new JsonResponse($responseBody, $exception->getCode(), [], true);

        $event->setResponse($response);
    }
}