<?php

declare(strict_types=1);

namespace App\Tests\Service\Segment;

use App\Entity\SegmentResponseDto;
use App\Service\Segment\SegmentService;
use App\Util\XMLReader;
use PHPUnit\Framework\TestCase;

class SegmentServiceTest extends TestCase
{
    private SegmentService $sut;
    private XMLReader $reader;

    protected function setUp(): void
    {
        $this->reader = $this->createMock(XMLReader::class);
        $this->sut = new SegmentService($this->reader, 'https://test.com');
    }

    public function testRead_returnExpectedResponse()
    {
        $this->reader
            ->expects($this->once())
            ->method('parse')
            ->with('https://test.com?origin=MAD&destination=BIO&date=2022-06-01')
            ->willReturn($this->stubSimpleXMLElementArray());

        $expected = $this->expected();
        $actual = $this->sut->read('MAD', 'BIO', '2022-06-01');

        $this->assertEquals($expected, $actual);
    }

    public function testRead_returnFailureResponse()
    {
        $expectedException = $this->createMock(\Exception::class);

        $this->reader
            ->expects($this->any())
            ->method('parse')
            ->with('https://test.com?origin=MAD&destination=BIO&date=2022-06-01')
            ->willThrowException($expectedException);

        $actual = $this->sut->read('MAD', 'BIO', '2022-06-01');

        $this->assertArrayHasKey('class', $actual);
        $this->assertArrayHasKey('message', $actual);
    }

    private function expected(): array
    {
        $segmentResponseDto1 = new SegmentResponseDto(
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            \Datetime::createFromFormat('Y-m-d H:i','2022-06-01 11:50'),
            \Datetime::createFromFormat('Y-m-d','2022-06-01'),
            '0426',
            'IB',
            'Iberia'
        );
        $segmentResponseDto2 = new SegmentResponseDto(
            'MAD',
            'Madrid Adolfo Suarez-Barajas',
            'BIO',
            'Bilbao',
            \Datetime::createFromFormat('Y-m-d H:i','2022-06-01 15:55'),
            \Datetime::createFromFormat('Y-m-d','2022-06-01'),
            '0438',
            'IB',
            'Iberia'
        );

        return [
            $segmentResponseDto1->toArray(),
            $segmentResponseDto2->toArray(),
        ];
    }

    /**
     * @return \SimpleXMLElement[]
     */
    private function stubSimpleXMLElementArray(): array
    {
        return [
            new \SimpleXMLElement($this->simpleXMLElement1()),
            new \SimpleXMLElement($this->simpleXMLElement2()),
        ];
    }

    private function simpleXMLElement1(): string
    {
        return <<<XML
            <FlightSegment>
            <Departure>
            <AirportCode>MAD</AirportCode>
            <Date>2022-06-01</Date>
            <Time>11:50</Time>
            <AirportName>Madrid Adolfo Suarez-Barajas</AirportName>
            <Terminal>
            <Name>4</Name>
            </Terminal>
            </Departure>
            <Arrival>
            <AirportCode>BIO</AirportCode>
            <Date>2022-06-01</Date>
            <Time>12:55</Time>
            <ChangeOfDay>0</ChangeOfDay>
            <AirportName>Bilbao</AirportName>
            </Arrival>
            <MarketingCarrier>
            <AirlineID>IB</AirlineID>
            <Name>Iberia</Name>
            <FlightNumber>0426</FlightNumber>
            </MarketingCarrier>
            <OperatingCarrier>
            <AirlineID>IB</AirlineID>
            <Name>Iberia</Name>
            <Disclosures>
            <Description>
            <Text>IB</Text>
            </Description>
            </Disclosures>
            </OperatingCarrier>
            <Equipment>
            <AircraftCode>321</AircraftCode>
            <Name>Airbus A321</Name>
            </Equipment>
            <FlightDetail>
            <FlightDuration>
            <Value>PT1H5M</Value>
            </FlightDuration>
            </FlightDetail>
            </FlightSegment>
        XML;
    }

    private function simpleXMLElement2(): string
    {
        return <<<XML
            <FlightSegment>
            <Departure>
            <AirportCode>MAD</AirportCode>
            <Date>2022-06-01</Date>
            <Time>15:55</Time>
            <AirportName>Madrid Adolfo Suarez-Barajas</AirportName>
            <Terminal>
            <Name>4</Name>
            </Terminal>
            </Departure>
            <Arrival>
            <AirportCode>BIO</AirportCode>
            <Date>2022-06-01</Date>
            <Time>17:00</Time>
            <ChangeOfDay>0</ChangeOfDay>
            <AirportName>Bilbao</AirportName>
            </Arrival>
            <MarketingCarrier>
            <AirlineID>IB</AirlineID>
            <Name>Iberia</Name>
            <FlightNumber>0438</FlightNumber>
            </MarketingCarrier>
            <OperatingCarrier>
            <AirlineID>IB</AirlineID>
            <Name>Iberia</Name>
            <Disclosures>
            <Description>
            <Text>IB</Text>
            </Description>
            </Disclosures>
            </OperatingCarrier>
            <Equipment>
            <AircraftCode>321</AircraftCode>
            <Name>Airbus A321</Name>
            </Equipment>
            <FlightDetail>
            <FlightDuration>
            <Value>PT1H5M</Value>
            </FlightDuration>
            </FlightDetail>
            </FlightSegment>
        XML;
    }
}