<?php

namespace MulerTech\EventManager;

use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Class EventManager
 * @package MulerTech\EventManager
 * @author Sébastien Muler
 */
class Event implements EventInterface, StoppableEventInterface
{
    /**
     * @var string
     */
    private string $name = '';

    /**
     * @var mixed
     */
    private mixed $target;

    /**
     * @var array<string, mixed>
     */
    private array $params = [];

    /**
     * @var bool
     */
    private bool $propagationStopped = false;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
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

    /**
     * @param string $name
     * @return mixed
     */
    public function getParam(string $name): mixed
    {
        return $this->params[$name] ?? null;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param object|string|null $target
     * @return void
     */
    public function setTarget(object|string|null $target): void
    {
        $this->target = $target;
    }

    /**
     * @param array<string, mixed> $params
     * @return void
     */
    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    /**
     * @param bool $flag
     * @return void
     */
    public function stopPropagation(bool $flag = true): void
    {
        $this->propagationStopped = $flag;
    }

    /**
     * @return bool
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }
}
