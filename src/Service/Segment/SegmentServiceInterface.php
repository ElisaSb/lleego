<?php

namespace App\Service\Segment;

interface SegmentServiceInterface
{
    public function read($origin, string $destination, string $date): array;
}