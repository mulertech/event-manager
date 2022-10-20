<?php


namespace mtphp\EventManager\Tests\FakeClass;


use mtphp\EventManager\ListenerInterface;

class FakeListeners4 implements ListenerInterface
{

    /**
     * @inheritDoc
     */
    public static function getListeners(): array
    {
        return ['person.event' => 'echoMiddleAndStop'];
    }


    public function echoMiddleAndStop(PersonEvent $event): void
    {
        echo ' Other message and stop propagation...';
        $event->stopPropagation();
    }


}