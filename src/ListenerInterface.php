<?php

namespace MulerTech\EventManager;

/**
 * Interface ListenerInterface
 * @package MulerTech\EventManager
 * @author Sébastien Muler
 */
interface ListenerInterface
{
    /**
     * Get the list of event listeners, examples :
     * ['person.event' => 'echoHello']
     * ['person.event' => ['echoHello','echoEnd','echoWelcome']]
     * ['person.event' => [['echoHello', 10],['echoEnd', 0],['echoWelcome', 1]]]
     * @return array<string, string|array<int, string>|array<int, array<string, int>>>
     */
    public static function getListeners(): array;
}
