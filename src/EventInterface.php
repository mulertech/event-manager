<?php

namespace MulerTech\EventManager;

/**
 * Interface EventInterface.
 *
 * @author Sébastien Muler
 */
interface EventInterface
{
    public function getName(): string;

    public function getTarget(): mixed;

    /**
     * @return array<string, mixed>
     */
    public function getParams(): array;

    public function getParam(string $name): mixed;

    public function setName(string $name): void;

    public function setTarget(object|string|null $target): void;

    /**
     * @param array<string, mixed> $params
     */
    public function setParams(array $params): void;

    public function stopPropagation(bool $flag): void;

    public function isPropagationStopped(): bool;
}
