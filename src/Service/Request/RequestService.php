<?php

declare(strict_types=1);

namespace App\Service\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestService
{
    /**
     * @return mixed
     */
    public static function getField(Request $request, string $fieldName, bool $isRequired = true)
    {
        if ((null === $param = $request->query->get($fieldName)) && $isRequired) {
            throw new BadRequestHttpException(\sprintf('Missing field %s', $fieldName));
        }

        return $param;
    }
}