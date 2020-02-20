<?php

declare(strict_types=1);

namespace App\Saga;

use App\Event\DoSomethingWasPrepared;
use App\Event\DoSomethingWasRequested;
use App\ProcessManager\Saga;
use App\ProcessManager\SagaMessage;
use App\ProcessManager\State;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class FirstSaga extends Saga implements MessageSubscriberInterface
{
    public function onDoSomethingWasRequested(DoSomethingWasRequested $event)
    {
        echo "## FIRST onDoSomethingWasRequested\n";
        echo "    SagaID: " . $event->getSagaId() . PHP_EOL;
        echo "    " . json_encode($event->getConfig()) . PHP_EOL;
        $this->state->set('test', 1);
//        $this->messageBus->dispatch(new DoSomethingWasPrepared($event->getSagaId()));
    }

    public function onDoSomethingWasPrepared(DoSomethingWasPrepared $event)
    {
        echo "## FIRST onDoSomethingWasPrepared\n";
        echo "    SagaID: " . $event->getSagaId() . PHP_EOL;
    }


}
