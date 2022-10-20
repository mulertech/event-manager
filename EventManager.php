<?php


namespace mtphp\EventManager;


use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use RuntimeException;

/**
 * Class EventManager
 * @package mtphp\EventManager
 * @author Sébastien Muler
 */
class EventManager implements EventManagerInterface, EventDispatcherInterface, ListenerProviderInterface
{

    /**
     * @var array
     */
    private $listeners = [];

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
     * @param ListenerInterface $listener
     * @return bool
     */
    public function addListeners(ListenerInterface $listener): bool
    {
        foreach ($listener->getListeners() as $eventName => $args) {
            if (is_string($args)) {
                if (!is_callable([$listener, $args])) {
                    Throw new RuntimeException(sprintf('Class EventManager, function addListeners. The listener (%s) hasn\'t function called "%s"...', get_class($listener), $args));
                }
                $this->addListener($eventName, [$listener, $args]);
            } elseif (is_array($args)) {
                foreach ($args as $oneListener) {
                    if (is_array($oneListener)) {
                        if (!is_callable([$listener, $oneListener[0]])) {
                            Throw new RuntimeException(sprintf('Class EventManager, function addListeners. The listener (%s) hasn\'t function called "%s"...', get_class($listener), $oneListener[0]));
                        }
                        $this->addListener($eventName, [$listener, $oneListener[0]], $oneListener[1] ?? 0);
                    } else {
                        if (!is_callable([$listener, $oneListener])) {
                            Throw new RuntimeException(sprintf('Class EventManager, function addListeners. The listener (%s) hasn\'t function called "%s"...', get_class($listener), $oneListener));
                        }
                        $this->addListener($eventName, [$listener, $oneListener]);
                    }
                }
            }
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
}