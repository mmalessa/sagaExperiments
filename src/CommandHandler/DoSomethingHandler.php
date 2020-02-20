<?php

declare(strict_types=1);

namespace App\CommandHandler;

use App\Command\DoSomething;
use App\Event\DoSomethingWasRequested;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DoSomethingHandler implements MessageHandlerInterface
{
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(DoSomething $event)
    {
        echo "## doSomethingHandler\n";
        echo "    " . json_encode($event->getConfig()) . PHP_EOL;

        $sagaId = 'SomeSagaId';

        $this->messageBus->dispatch(new DoSomethingWasRequested(
            $sagaId,
            $event->getConfig()
        ));
    }
}
