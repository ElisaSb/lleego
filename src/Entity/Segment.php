<?php

namespace App\Entity;

class Segment
{
    /**
     * Origin IATA code, for example PMI
     * @var string
     * @example PMI
     */
    private $originCode;

    /**
     * Origin name, for example Palma de Mallorca
     * @var string
     * @example Palma de Mallorca
     */
    private $originName;

    /**
     * Destination IATA code, for example MAD
     * @var string
     * @example MAD
     */
    private $destinationCode;

    /**
     * Destination IATA code, for example MAD
     * @var string
     * @example Madrid Adolfo Suárez Barajas
     */
    private $destinationName;

    /**
     * Departure date time
     * @var \DateTime
     */
    private $start;

    /**
     * Arrival date time
     * @var \DateTime
     */
    private $end;

    /**
     * Transport or flight number
     * @var string
     * @example 3975
     */
    private $transportNumber;

    /**
     * Company / airline code
     * @var string
     * @example IB
     */
    private $companyCode;

    /**
     * Company / airline name
     * @var string
     * @example Iberia
     */
    private $companyName;

    private function __construct(string $originCode, string $originName, string $destinationCode, string $destinationName, \DateTime $start, \DateTime $end, string $transportNumber, string $companyCode, string $companyName)
    {
        $this->originCode = $originCode;
        $this->originName = $originName;
        $this->destinationCode = $destinationCode;
        $this->destinationName = $destinationName;
        $this->start = $start;
        $this->end = $end;
        $this->transportNumber = $transportNumber;
        $this->companyCode = $companyCode;
        $this->companyName = $companyName;
    }

    public static function fromDto(SegmentResponseDto $segmentResponseDto): Segment
    {
        return new Segment(
            $segmentResponseDto->originCode(),
            $segmentResponseDto->originName(),
            $segmentResponseDto->destinationCode(),
            $segmentResponseDto->destinationName(),
            $segmentResponseDto->start(),
            $segmentResponseDto->end(),
            $segmentResponseDto->transportNumber(),
            $segmentResponseDto->companyCode(),
            $segmentResponseDto->companyName()
        );
    }

    public function toDto(): SegmentResponseDto
    {
        return new SegmentResponseDto(
            $this->originCode,
            $this->originName,
            $this->destinationCode,
            $this->destinationName,
            $this->start,
            $this->end,
            $this->transportNumber,
            $this->companyCode,
            $this->companyName,
        );
    }
}
