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
    public function getTarget();

    /**
     * @return array
     */
    public function getParams(): array;

    /**
     * @param string $name
     * @return mixed
     */
    public function getParam(string $name);

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @param null|string|object $target
     * @return void
     */
    public function setTarget($target): void;

    /**
     * @param array $params
     * @return void
     */
    public function setParams(array $params): void;

    /**
     * @param bool $flag
     * @return void
     */
    public function stopPropagation(bool $flag): void;

}