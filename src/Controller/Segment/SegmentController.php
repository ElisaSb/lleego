<?php

declare(strict_types=1);

namespace App\Controller\Segment;

use App\Controller\BaseController;
use App\Service\Request\RequestService;
use App\Service\Segment\SegmentServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SegmentController extends BaseController
{
    /**
     * @property SegmentServiceInterface $segmentService
     * @Route("/avail", name="readSegment")
     */
    public function read(
        Request $request,
        SegmentServiceInterface $segmentService
    ): JsonResponse
    {
        $flightSegmentList = $segmentService->read(
            RequestService::getField($request, 'origin'),
            RequestService::getField($request, 'destination'),
            RequestService::getField($request, 'date')
        );

        return new JsonResponse($flightSegmentList);
    }
}