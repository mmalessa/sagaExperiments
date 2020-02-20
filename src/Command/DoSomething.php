<?php

declare(strict_types=1);

namespace App\Command;

use App\Report\Command\RequestForAction;
use Broadway\CommandHandling\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DoSomething extends Command
{
    protected static $defaultName = 'app:do-something';
    private $commandBus;

//    public function __construct(CommandBus $commandBus)
//    {
//        $this->commandBus = $commandBus;
//        parent::__construct(null);
//    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $sagaId = 'fdde7198-cdc8-4b9b-b5e1-7529dde2fed8';
//        $this->commandBus->dispatch(new RequestForAction($sagaId));
    }
}
