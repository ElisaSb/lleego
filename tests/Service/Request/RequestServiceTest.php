<?php

declare(strict_types=1);

namespace App\Tests\Service\Request;

use App\Service\Request\RequestService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestServiceTest extends TestCase
{
    protected function setUp(): void
    {
        $this->sut = new RequestService();
    }

    public function testGetField_ReturnExpectedParam()
    {
        $request = $this->createMock(Request::class);
        $request->query = new InputBag([
            "origin" => "MAD",
            "destination" => "BIO",
            "date" => "2022-06-01"
        ]);

        $actual = $this->sut::getField($request, 'destination');

        $this->assertEquals('BIO', $actual);
    }

    public function testGetField_ReturnNull_WhenParamDoesNotExist()
    {
        $request = $this->createMock(Request::class);
        $request->query = new InputBag([
            "origin" => "MAD",
            "destination" => "BIO",
            "date" => "2022-06-01"
        ]);

        $this->expectException(BadRequestHttpException::class);
        $this->sut::getField($request, 'test');
    }

    public function testGetField_ReturnNull_WhenRequestHaveNotParam()
    {
        $request = $this->createMock(Request::class);
        $request->query = new InputBag([
            "origin" => "MAD",
            "date" => "2022-06-01"
        ]);

        $this->expectException(BadRequestHttpException::class);
        $this->sut::getField($request, 'destination');
    }
}