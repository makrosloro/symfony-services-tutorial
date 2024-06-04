<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationList;

class ValidationExceptionData extends ServiceExceptionData
{
    private ConstraintViolationList $violations;

    public function __construct(int $statusCode, string $type, ConstraintViolationList $violations)
    {
        parent::__construct($statusCode, $type);
        $this->violations = $violations;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'violations' => $this->getViolationsArray()

        ];
    }

    private function getViolationsArray(): array
    {
        $violations = [];
        foreach ($this->violations as $violation) {
            $violations[] = [
                'propertyPath' => $violation->getPropertyPath(),
                'message' => $violation->getMessage()
            ];
        }

        return $violations;
    }

}
