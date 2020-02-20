<?php

declare(strict_types=1);

namespace App\ProcessManager;

use App\Event\DoSomethingWasPrepared;
use App\Event\DoSomethingWasRequested;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class Saga
{
    protected $messageBus;
    protected $stateRepository;
    /** @var State */
    protected $state;

    public function __construct(
        StateRepository $stateRepository,
        MessageBusInterface $messageBus
    )
    {
        $this->stateRepository = $stateRepository;
        $this->messageBus = $messageBus;
    }

    public static function getHandledMessages(): iterable
    {
        $reflector = new \ReflectionClass(static::class);
        foreach ($reflector->getMethods() as $method) {
            if ($method->class === self::class) {
                continue;
            }
            if ($method->getNumberOfParameters() !== 1) {
                continue;
            }
            $reflectionParameter = $method->getParameters()[0];
            $parameterClassName = (string)$reflectionParameter->getType();

            echo "PC: $parameterClassName\n";

            yield $parameterClassName => ['method' => 'handle'];
        }
//        yield DoSomethingWasRequested::class => ['method' => 'handle'];
//        yield DoSomethingWasPrepared::class => ['method' => 'handle'];
    }

    public function handle(SagaMessage $event)
    {
        echo "HANDLE\n";
        $methodName = $this->findMethod($event);
        $this->state = $this->stateRepository->get($event->getSagaId());
        $this->{$methodName}($event);
        $this->stateRepository->save($this->state);
        echo "| STATE: " . json_encode($this->state->serialize()) . PHP_EOL;
    }

    private function findMethod(SagaMessage $event): ?string
    {
        $reflector = new \ReflectionClass(static::class);
        foreach ($reflector->getMethods() as $method) {
            if ($method->class === self::class) {
                continue;
            }
            if ($method->getNumberOfParameters() !== 1) {
                continue;
            }
            $reflectionParameter = $method->getParameters()[0];
            $parameterClass = (string)$reflectionParameter->getType();
            if ($parameterClass === get_class($event)) {
                return $method->getName();
            }
        }
        return null;
    }
}
