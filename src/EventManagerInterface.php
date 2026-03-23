<?php

namespace MulerTech\EventManager;

/**
 * Interface EventManagerInterface.
 *
 * @author Sébastien Muler
 */
interface EventManagerInterface
{
    public function addListener(string $event, callable $callback, int $priority = 0): bool;
}
