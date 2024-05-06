<?php

declare(strict_types=1);

namespace App\Util;

class XMLReader
{
    private const XPATH = '/soap:Envelope/soap:Body/flights:AirShoppingRS/flights:DataLists/flights:FlightSegmentList/flights:FlightSegment';
    private const NAMESPACE = 'http://www.iata.org/IATA/EDIST/2017.2';
    public function parse($url): array
    {
        $xml = simplexml_load_file($url);
        $xml->registerXPathNamespace('flights', self::NAMESPACE);

        return $xml->xpath(self::XPATH);
    }
}