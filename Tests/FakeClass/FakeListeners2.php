<?php


namespace mtphp\EventManager\Tests\FakeClass;


use mtphp\EventManager\ListenerInterface;

class FakeListeners2 implements ListenerInterface
{

    /**
     * @inheritDoc
     */
    public static function getListeners(): array
    {
        return [
            'person.event' => ['echoHello',
            'echoEnd',
            'echoWelcome']
        ];
    }


    public function echoHello($event) {
        echo 'Hello ' . $event->getTarget()->getName() . ' !';
    }

    public function echoEnd() {
        echo 'The end...';
    }

    public function echoWelcome() {
        echo 'Welcome !';
    }

}