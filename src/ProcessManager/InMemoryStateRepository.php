<?php

declare(strict_types=1);

namespace App\ProcessManager;

class InMemoryStateRepository implements StateRepository
{
    private $states = [];
    public function get(string $sagaId): State
    {
        if (!array_key_exists($sagaId, $this->states)) {
            return new State($sagaId);
        }
        return $this->states[$sagaId];
    }
    public function save(State $state): void
    {
        $sagaId = $state->getSagaId();
        if ($state->isDone()) {
            unset ($this->states[$sagaId]);
        } else {
            $this->states[$sagaId] = $state;
        }
    }
}
