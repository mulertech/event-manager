<?php

namespace MulerTech\EventManager;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Class EventManager.
 *
 * @author Sébastien Muler
 */
class Event implements EventInterface, StoppableEventInterface
{
    private string $name = '';

    private mixed $target;

    /**
     * @var array<string, mixed>
     */
    private array $params = [];

    private bool $propagationStopped = false;

    public function getName(): string
    {
        return $this->name;
    }

    public function getTarget(): mixed
    {
        return $this->target;
    }

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function getParam(string $name): mixed
    {
        return $this->params[$name] ?? null;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setTarget(object|string|null $target): void
    {
        $this->target = $target;
    }

    /**
     * @param array<string, mixed> $params
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function stopPropagation(bool $flag = true): void
    {
        $this->propagationStopped = $flag;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }
}
