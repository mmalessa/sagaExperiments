<?php

declare(strict_types=1);

namespace App\ProcessManager;

interface StateRepository
{
    public function get(string $sagaId): State;
    public function save(State $state): void;
}
