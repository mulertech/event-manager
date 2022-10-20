<?php


namespace mtphp\EventManager;

/**
 * Interface ListenerInterface
 * @package mtphp\EventManager
 * @author Sébastien Muler
 */
interface ListenerInterface
{

    /**
     * Get the list of event listeners, examples :
     * ['person.event' => 'echoHello']
     * ['person.event' => ['echoHello','echoEnd','echoWelcome']]
     * ['person.event' => [['echoHello', 10],['echoEnd', 0],['echoWelcome', 1]]]
     * @return array
     */
    public static function getListeners(): array;
}