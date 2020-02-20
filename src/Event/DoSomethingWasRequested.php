<?php

declare(strict_types=1);

namespace App\Event;

use App\ProcessManager\SagaMessage;

class DoSomethingWasRequested implements SagaMessage
{
    private $sagaId;
    private $config;

    public function __construct(string $sagaId, array $config)
    {
        $this->sagaId = $sagaId;
        $this->config = $config;
    }

    public function getSagaId(): string
    {
        return $this->sagaId;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

}
