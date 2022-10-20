<?php


namespace mtphp\EventManager;


use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Class EventManager
 * @package mtphp\EventManager
 * @author Sébastien Muler
 */
class Event implements EventInterface, StoppableEventInterface
{

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var mixed
     */
    private $target;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var bool
     */
    private static $propagationStopped = false;

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
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getParam(string $name)
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
     * @param null|string|object $target
     * @return void
     */
    public function setTarget($target): void
    {
        $this->target = $target;
    }

    /**
     * @param array $params
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
        self::$propagationStopped = $flag;
    }

    /**
     * @return bool
     */
    public function isPropagationStopped(): bool
    {
        return self::$propagationStopped;
    }
}