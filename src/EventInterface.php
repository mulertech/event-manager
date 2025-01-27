<?php

namespace MulerTech\EventManager;

/**
 * Interface EventInterface
 * @package MulerTech\EventManager
 * @author Sébastien Muler
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return mixed
     */
    public function getTarget(): mixed;

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array;

    /**
     * @param string $name
     * @return mixed
     */
    public function getParam(string $name): mixed;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @param object|string|null $target
     * @return void
     */
    public function setTarget(object|string|null $target): void;

    /**
     * @param array<string, mixed> $params
     * @return void
     */
    public function setParams(array $params): void;

    /**
     * @param bool $flag
     * @return void
     */
    public function stopPropagation(bool $flag): void;

    /**
     * @return bool
     */
    public function isPropagationStopped(): bool;
}
