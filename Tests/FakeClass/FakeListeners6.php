<?php

namespace MulerTech\EventManager\Tests\FakeClass;

use MulerTech\EventManager\ListenerInterface;

class FakeListeners6 implements ListenerInterface
{
    /**
     * @inheritDoc
     */
    public static function getListeners(): array
    {
        return ['person.event' => 'badMethod'];
    }

    public function echoTheEnd() {
        echo ' It\'s the end !';
    }
}