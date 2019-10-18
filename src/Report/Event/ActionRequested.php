<?php

declare(strict_types=1);

namespace App\Report\Event;

use Mmalessa\Saga\Identifiable;

class ActionRequested implements Identifiable
{
    private $processId;

    public function __construct(string $processId)
    {
        $this->processId = $processId;
    }

    public function getId(): string
    {
        return $this->processId;
    }
}
