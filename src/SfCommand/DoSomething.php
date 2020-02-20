<?php

declare(strict_types=1);

namespace App\SfCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DoSomething extends Command
{
    protected static $defaultName = 'app:do-something';
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = ['login' => 'user', 'password' => 'SuPeRpAsSwOrd'];
        $this->messageBus->dispatch(new \App\Command\DoSomething($config));
    }
}
