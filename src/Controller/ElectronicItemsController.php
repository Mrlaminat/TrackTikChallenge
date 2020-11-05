<?php

namespace App\Controller;

use App\Serializer\DataSerializer;
use App\Service\ElectronicService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ElectronicItemsController
 * @package App\Controller
 */
final class ElectronicItemsController extends AbstractController
{
    /**
     * @var LoggerInterface $logger
     */
    protected LoggerInterface $logger;

    /**
     * @var DataSerializer $serializer
     */
    private DataSerializer $serializer;

    /**
     * @var ElectronicService $electronicService
     */
    protected ElectronicService $electronicService;

    /**
     * ElectronicItemsController constructor.
     * @param LoggerInterface $logger
     * @param ElectronicService $electronicService
     * @param DataSerializer $serializer
     */
    public function __construct(
        LoggerInterface $logger,
        ElectronicService $electronicService,
        DataSerializer $serializer
    ) {
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->electronicService = $electronicService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function baseScenarioAction(Request $request): JsonResponse
    {
        $electronicItems = json_decode($request->getContent(), 1);

        $result = [];
        try {
            $result = $this->electronicService->proceedElectronicItems($electronicItems);
        } catch (\Exception $exception) {
            $this->logger->critical(
                sprintf(
                    'Error message: %s, with status: %s and trace: %s.',
                    $exception->getMessage(), $exception->getCode(), $exception->getTrace()
                )
            );
        }

        return new JsonResponse(
            $this->serializer->serialize($result, 'json'),
            200,
            [
                'Content-Type' => 'application/json',
            ],
            true
        );
    }
}
