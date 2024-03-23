<?php

namespace MulerTech\EventManager;

/**
 * Interface EventManagerInterface
 * @package MulerTech\EventManager
 * @author Sébastien Muler
 */
interface EventManagerInterface
{

    /**
     * @param string $event
     * @param callable $callback
     * @param int $priority
     * @return bool
     */
    public function addListener(string $event, callable $callback, int $priority = 0): bool;

}