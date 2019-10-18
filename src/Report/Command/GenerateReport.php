<?php

declare(strict_types=1);

namespace App\Report\Command;

class GenerateReport
{
    private $sagaId;

    public function __construct(string $sagaId)
    {
        $this->sagaId = $sagaId;
    }

    public function getSagaId(): string
    {
        return $this->sagaId;
    }
}
