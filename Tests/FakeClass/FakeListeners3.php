<?php

namespace MulerTech\EventManager\Tests\FakeClass;

use MulerTech\EventManager\ListenerInterface;

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