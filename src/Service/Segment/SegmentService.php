<?php

declare(strict_types=1);

namespace App\Service\Segment;

use App\Entity\SegmentResponseDto;
use App\Util\XMLReader;

class SegmentService implements SegmentServiceInterface
{
    private string $url_request;
    private XMLReader $reader;

    public function __construct(XMLReader $reader, string $url_request)
    {
        $this->url_request = $url_request;
        $this->reader = $reader;
    }

    public function read($origin, $destination, $date): array
    {
        $url = \sprintf(
            '%s?origin=%s&destination=%s&date=%s',
            $this->url_request,
            $origin,
            $destination,
            $date
        );

        try {
            $flightSegmentList = $this->reader->parse($url);
        } catch (\Exception $e) {
            return [
                'class' => $e->getFile(),
                'message' => $e->getMessage()
            ];
        }

        $segmentList = [];

        foreach ($flightSegmentList as $flightSegment) {
            $segmentList[] = $this->createSegmentResponseDto($flightSegment)->toArray();
        }

        return $segmentList;
    }

    private function createSegmentResponseDto(\SimpleXMLElement $flightSegment): SegmentResponseDto
    {
        $startDate = $flightSegment->Departure->Date->__toString();
        $startTime = $flightSegment->Departure->Time->__toString();

        return new SegmentResponseDto(
            $flightSegment->Departure->AirportCode->__toString(),
            $flightSegment->Departure->AirportName->__toString(),
            $flightSegment->Arrival->AirportCode->__toString(),
            $flightSegment->Arrival->AirportName->__toString(),
            \Datetime::createFromFormat('Y-m-d H:i', $startDate . " " . $startTime),
            \Datetime::createFromFormat('Y-m-d', $flightSegment->Departure->Date->__toString()),
            $flightSegment->MarketingCarrier->FlightNumber->__toString(),
            $flightSegment->MarketingCarrier->AirlineID->__toString(),
            $flightSegment->MarketingCarrier->Name->__toString()
        );
    }
}