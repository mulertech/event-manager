<?php

namespace MulerTech\EventManager\Tests\FakeClass;

use MulerTech\EventManager\ListenerInterface;

class FakeListeners1 implements ListenerInterface
{

    /**
     * @inheritDoc
     */
    public static function getListeners(): array
    {
        return [
            'person.event' => [['echoHello', 10],
            ['echoEnd', 0],
            ['echoWelcome', 1]]
        ];
    }


    public function echoHello() {
        echo 'Hello !';
    }

    public function echoEnd() {
        echo 'The end...';
    }

    public function echoWelcome() {
        echo 'Welcome !';
    }

}