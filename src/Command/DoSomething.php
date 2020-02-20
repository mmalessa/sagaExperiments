<?php

declare(strict_types=1);

namespace App\Command;

class DoSomething
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
