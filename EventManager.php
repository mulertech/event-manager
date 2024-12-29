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
     * @var array
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
     * @throws ListenerException
     */
    public function addListeners(ListenerInterface $listeners): bool
    {
        foreach ($listeners->getListeners() as $eventName => $args) {
            $this->extractListeners($listeners, $eventName, $args);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(object $event): object
    {
        if (isset($this->listeners[$event->getName()])) {
            foreach ($this->getListenersForEvent($event) as ['callback' => $callback]) {
                if ($event->isPropagationStopped()) {
                    break;
                }

                $callback($event);
            }
        }

        return $event;
    }

    /**
     * @param object $event
     * @return iterable
     */
    public function getListenersForEvent(object $event): iterable
    {
        $listeners = $this->listeners[$event->getName()];

        usort($listeners, static function ($listenerA, $listenerB) {
            return $listenerB['priority'] - $listenerA['priority'];
        });

        return $listeners;
    }

    /**
     * @throws ListenerException
     */
    private function extractListeners(ListenerInterface $listeners, string $eventName, string|array $args): void
    {
        if (is_string($args)) {
            if (!is_callable([$listeners, $args])) {
                $this->throwException($listeners, $args);
            }

            $this->addListener($eventName, [$listeners, $args]);
            return;
        }

        foreach ($args as $listener) {
            if (is_array($listener)) {
                if (!is_callable([$listeners, $listener[0]])) {
                    $this->throwException($listeners, $listener[0]);
                }

                $this->addListener($eventName, [$listeners, $listener[0]], $listener[1] ?? 0);
                continue;
            }

            if (!is_callable([$listeners, $listener])) {
                $this->throwException($listeners, $listener);
            }

            $this->addListener($eventName, [$listeners, $listener]);
        }
    }

    /**
     * @throws ListenerException
     */
    private function throwException(ListenerInterface $listeners, string $method): void
    {
        Throw new ListenerException(
            sprintf(
                'Class EventManager. The listener (%s) hasn\'t function called "%s"...',
                $listeners::class,
                $method
            )
        );
    }
}