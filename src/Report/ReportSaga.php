<?php

declare(strict_types=1);

namespace App\Report;

use App\Report\Command\GenerateReport;
use App\Report\Command\GetDataFromFirstAPI;
use App\Report\Command\GetDataFromSecondAPI;
use App\Report\Command\SendEmail;
use App\Report\Event\ActionRequested;
use App\Report\Event\EmailWasSent;
use App\Report\Event\FirstAPIDataHasBeenDownloaded;
use App\Report\Event\ReportHasBeenGenerated;
use App\Report\Event\SecondAPIDataHasBeenDownloaded;
use Broadway\CommandHandling\CommandBus;
use Mmalessa\Saga\Saga;
use Mmalessa\Saga\State;
use Mmalessa\Saga\StateRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ReportSaga extends Saga implements EventSubscriberInterface
{
    const EVENTS = [
        // Event class name => ['methodName', priority]
        ActionRequested::class => ['actionRequested', 1],
        FirstAPIDataHasBeenDownloaded::class => ['firstAPIDataHasBeenDownloaded', 1],
        SecondAPIDataHasBeenDownloaded::class => ['secondAPIDataHasBeenDownloaded', 1],
        ReportHasBeenGenerated::class => ['reportHasBeenGenerated', 1],
        EmailWasSent::class => ['emailWasSent', 1],
    ];
    private $commandBus;

    public function __construct(StateRepository $stateRepository, string $type, CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct($stateRepository, $type);
    }

    public function actionRequested(ActionRequested $event, State $state): State
    {
        $state->set('startedAt', date('Y-m-d H:i:s'));
        if (rand(0, 100) < 50) {
            $this->commandBus->dispatch(new GetDataFromFirstAPI($state->getSagaId()));
            $this->commandBus->dispatch(new GetDataFromSecondAPI($state->getSagaId()));
        } else {
            $this->commandBus->dispatch(new GetDataFromSecondAPI($state->getSagaId()));
            $this->commandBus->dispatch(new GetDataFromFirstAPI($state->getSagaId()));
        }
        $this->showState($state);
        return $state;
    }

    public function firstAPIDataHasBeenDownloaded(FirstAPIDataHasBeenDownloaded $event, State $state): State
    {
        echo "  -> firstAPIDataHasBeenDownloaded\n";
        $state->set('firstReport', 'OK');
        if ($state->get('firstReport') === 'OK' && $state->get('secondReport') === 'OK') {
            $this->commandBus->dispatch(new GenerateReport($state->getSagaId()));
            $state->set('report', 'OK');
        } else {
            echo "  /Could not generate report yet./\n";
        }
        $this->showState($state);
        return $state;
    }

    public function secondAPIDataHasBeenDownloaded(SecondAPIDataHasBeenDownloaded $event, State $state): State
    {
        echo "  -> secondAPIDataHasBeenDownloaded\n";
        $state->set('secondReport', 'OK');
        if ($state->get('firstReport') === 'OK' && $state->get('secondReport') === 'OK') {
            $this->commandBus->dispatch(new GenerateReport($state->getSagaId()));
        } else {
            echo "  /Could not generate report yet./\n";
        }
        $this->showState($state);
        return $state;
    }


    public function reportHasBeenGenerated(ReportHasBeenGenerated $event, State $state): State
    {
        echo "  -> Report has been generated.\n";
        $state->set('report', 'OK');
        $this->commandBus->dispatch(new SendEmail($state->getSagaId()));
        $this->showState($state);
        return $state;
    }

    public function emailWasSent(EmailWasSent $event, State $state): State
    {
        echo "  -> Email was sent.\n";
        $state->setDone();
        echo "Saga -> DONE\n";
        $this->showState($state);
        return $state;
    }

    private function showState(State $state)
    {
        print_r($state);
    }
}
