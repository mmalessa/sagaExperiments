<?php

namespace App\ProcessManager;

interface SagaMessage
{
    public function getSagaId(): string;
}
