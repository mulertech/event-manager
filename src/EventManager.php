<?php

namespace MulerTech\EventManager;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * Class EventManager
 * @package MulerTech\EventManager
 * @author Sébastien Muler
 */
class EventManager implements EventManagerInterface, EventDispatcherInterface, ListenerProviderInterface
{
    /**
     * @var array<string, array<int, array<string, callable|int>>> $listeners
     */
    private array $listeners = [];

    /**
     * @inheritDoc
     */
    public function addListener(string $event, callable $callback, int $priority = 0): bool
    {
        $this->listeners[$event][] = [
            'callback' => $callback,
            'priority' => $priority
        ];

        return true;
    }

    /**
     * Extract the ListenerInterface into the listeners list.
     * @param ListenerInterface $listeners
     * @return bool
     */
    public function addListeners(ListenerInterface $listeners): bool
    {
        foreach ($listeners->getListeners() as $eventName => $args) {
            $this->extractListeners($listeners, $eventName, $args);
        }

        return true;
    }

    /**
     * @param EventInterface $event
     * @return object
     */
    public function dispatch(object $event): object
    {
        if (isset($this->listeners[$event->getName()])) {
            foreach ($this->getListenersForEvent($event) as ['callback' => $callback]) {
                if ($event->isPropagationStopped()) {
                    break;
                }

                if (is_callable($callback)) {
                    $callback($event);
                }
            }
        }

        return $event;
    }

    /**
     * @param EventInterface $event
     * @return iterable<int, array<string, callable|int>>
     */
    public function getListenersForEvent(object $event): iterable
    {
        $listeners = $this->listeners[$event->getName()];

        usort($listeners, static function ($listenerA, $listenerB) {
            $priorityA = $listenerA['priority'];
            $priorityB = $listenerB['priority'];

            if (!is_int($priorityA) || !is_int($priorityB)) {
                return 0;
            }

            return $priorityB - $priorityA;
        });

        return $listeners;
    }

    /**
     * @param ListenerInterface $listeners
     * @param string $eventName
     * @param string|array<int, string>|array<int, array<string, int>> $args
     * @return void
     * @throws ListenerException
     */
    private function extractListeners(
        ListenerInterface $listeners,
        string $eventName,
        string|array $args,
        int $priority = 0
    ): void {
        if (is_string($args)) {
            $callable = [$listeners, $args];

            if (!is_callable($callable)) {
                $this->throwException($listeners, $args);
            }

            /** @var Callable $callable */
            $this->addListener($eventName, $callable, $priority);
            return;
        }

        foreach ($args as $listener) {
            if (is_array($listener)) {
                /** @phpstan-ignore nullCoalesce.offset */
                $priority = $listener[1] ?? 0;
                /** @phpstan-ignore nullCoalesce.offset */
                $method = $listener[0] ?? 'Listener method not given';
                $this->extractListeners($listeners, $eventName, $method, $priority);
                continue;
            }

            $this->extractListeners($listeners, $eventName, $listener);
        }
    }

    /**
     * @throws ListenerException
     */
    private function throwException(ListenerInterface $listeners, string $method): void
    {
        throw new ListenerException(
            sprintf(
                'Class EventManager. The listener (%s) hasn\'t function called "%s"...',
                $listeners::class,
                $method
            )
        );
    }
}
