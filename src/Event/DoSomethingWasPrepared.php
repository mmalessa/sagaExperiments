<?php

declare(strict_types=1);

namespace App\Event;

use App\ProcessManager\SagaMessage;

class DoSomethingWasPrepared implements SagaMessage
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
