<?php

declare(strict_types=1);

namespace App\Report;

use App\Report\Command\RequestForAction;
use App\Report\Command\GenerateReport;
use App\Report\Command\GetDataFromFirstAPI;
use App\Report\Command\GetDataFromSecondAPI;
use App\Report\Command\SendEmail;
use App\Report\Event\ActionRequested;
use App\Report\Event\EmailWasSent;
use App\Report\Event\FirstAPIDataHasBeenDownloaded;
use App\Report\Event\ReportHasBeenGenerated;
use App\Report\Event\SecondAPIDataHasBeenDownloaded;
use Broadway\CommandHandling\SimpleCommandHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ReportCommandHandler extends SimpleCommandHandler
{
    private $eventDispatcher;

    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function handleRequestForAction(RequestForAction $command)
    {
        echo "RequestForAction...  \n";
        $this->eventDispatcher->dispatch(new ActionRequested($command->getSagaId()));
    }

    public function handleGetDataFromFirstAPI(GetDataFromFirstAPI $command)
    {
        echo "GetDataFromFirstAPI...  ";
        sleep(1);
        echo "OK\n";
        $this->eventDispatcher->dispatch(new FirstAPIDataHasBeenDownloaded($command->getSagaId()));
    }

    public function handleGetDataFromSecondAPI(GetDataFromSecondAPI $command)
    {
        echo "GetDataFromSecondAPI...  ";
        sleep(1);
        echo "OK\n";
        $this->eventDispatcher->dispatch(new SecondAPIDataHasBeenDownloaded($command->getSagaId()));
    }

    public function handleGenerateReport(GenerateReport $command)
    {
        echo "Generation report...  ";
        sleep(1);
        echo "OK\n";
        $this->eventDispatcher->dispatch(new ReportHasBeenGenerated($command->getSagaId()));
    }

    public function handleSendEmail(SendEmail $command)
    {
        echo "Sending e-mail...  ";
        sleep(1);
        echo "OK\n";
        $this->eventDispatcher->dispatch(new EmailWasSent($command->getSagaId()));
    }
}
