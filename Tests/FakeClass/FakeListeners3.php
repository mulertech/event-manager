<?php


namespace mtphp\EventManager\Tests\FakeClass;


use mtphp\EventManager\ListenerInterface;

class FakeListeners3 implements ListenerInterface
{

    /**
     * @inheritDoc
     */
    public static function getListeners(): array
    {
        return ['person.event' => 'echoHello'];
    }


    public function echoHello() {
        echo 'Hello World !';
    }


}