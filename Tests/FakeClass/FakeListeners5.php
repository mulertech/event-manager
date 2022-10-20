<?php


namespace mtphp\EventManager\Tests\FakeClass;


use mtphp\EventManager\ListenerInterface;

class FakeListeners5 implements ListenerInterface
{

    /**
     * @inheritDoc
     */
    public static function getListeners(): array
    {
        return ['person.event' => 'echoTheEnd'];
    }


    public function echoTheEnd() {
        echo ' It\'s the end !';
    }


}