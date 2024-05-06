<?php

declare(strict_types=1);

namespace App\Entity;

class SegmentResponseDto
{
    private string $originCode;
    private string $originName;
    private string $destinationCode;
    private string $destinationName;
    private \DateTime $start;
    private \DateTime $end;
    private string $transportNumber;
    private string $companyCode;
    private string $companyName;

    /**
     * @param string $originCode
     * @param string $originName
     * @param string $destinationCode
     * @param string $destinationName
     * @param \DateTime $start
     * @param \DateTime $end
     * @param string $transportNumber
     * @param string $companyCode
     * @param string $companyName
     */
    public function __construct(
        string $originCode,
        string $originName,
        string $destinationCode,
        string $destinationName,
        \DateTime $start,
        \DateTime $end,
        string $transportNumber,
        string $companyCode,
        string $companyName
    )
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

    public function originCode(): string
    {
        return $this->originCode;
    }

    public function originName(): string
    {
        return $this->originName;
    }

    public function destinationCode(): string
    {
        return $this->destinationCode;
    }

    public function destinationName(): string
    {
        return $this->destinationName;
    }

    public function start(): \DateTime
    {
        return $this->start;
    }

    public function end(): \DateTime
    {
        return $this->end;
    }

    public function transportNumber(): string
    {
        return $this->transportNumber;
    }

    public function companyCode(): string
    {
        return $this->companyCode;
    }

    public function companyName(): string
    {
        return $this->companyName;
    }

    public function toArray(): array
    {
        return [
            "originCode" => $this->originCode,
            "originName" => $this->originName,
            "start" => $this->start->format('Y-m-d H:i'),
            "destinationCode" => $this->destinationCode,
            "destinationName" => $this->destinationName,
            "end" => $this->end->format('Y-m-d'),
            "transportNumber" => $this->transportNumber,
            "companyCode" => $this->companyCode,
            "companyName" => $this->companyName,
        ];
    }
}