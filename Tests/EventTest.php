<?php

namespace mtphp\EventManager\Tests;

use mtphp\EventManager\EventManager;
use mtphp\EventManager\Tests\FakeClass\EntityOne;
use mtphp\EventManager\Tests\FakeClass\FakeListeners4;
use mtphp\EventManager\Tests\FakeClass\FakeListeners5;
use PHPUnit\Framework\TestCase;
use mtphp\EventManager\Tests\FakeClass\FakeListeners1;
use mtphp\EventManager\Tests\FakeClass\FakeListeners2;
use mtphp\EventManager\Tests\FakeClass\FakeListeners3;
use mtphp\EventManager\Tests\FakeClass\PersonEvent;

class EventTest extends TestCase
{

    private function getPersonEventClear($entity): PersonEvent
    {
        $personEvent = new PersonEvent($entity);
        $personEvent->stopPropagation(false);
        return $personEvent;
    }

    public function testOneEvent(): void
    {
        $obj = new EntityOne();
        $obj->age = 30;
        $obj->name = 'john';
        //Events actions
        $manager = new EventManager();
        $manager->addListener('person.event', static function (PersonEvent $event) {
            $event->getTarget()->setTest('hello ' . $event->getTarget()->getName());
        });
        //In the class that call this event
        $manager->dispatch($this->getPersonEventClear($obj));
        self::assertEquals('hello john', $obj->getTest());
    }

    public function testTwoEvents(): void
    {
        $obj = new EntityOne();
        $obj->age = 30;
        $obj->name = 'john';
        //Events actions
        $manager = new EventManager();
        $manager->addListener('person.event', static function ($event) {
            $event->getTarget()->setTest('hello ' . $event->getTarget()->getName());
        });
        $manager->addListener('person.event', static function ($event) {
            $event->getTarget()->setAdult($event->getTarget()->getAge() > 17);
        });
        //In the class that call this event
        $manager->dispatch($this->getPersonEventClear($obj));
        self::assertEquals('hello john', $obj->getTest());
        self::assertTrue($obj->isAdult());
    }

    public function testMultipleEventsWithPriority(): void
    {
        $obj = new EntityOne();
        $obj->age = 30;
        $obj->name = 'john';
        //Events actions
        $manager = new EventManager();
        $manager->addListener('person.event', static function (PersonEvent $event) {echo 'event1';}, 10);
        $manager->addListener('person.event', static function (PersonEvent $event) {echo 'event2';}, 9);
        $manager->addListener('person.event', static function (PersonEvent $event) {echo 'event3';}, 8);
        $manager->addListener('person.event', static function (PersonEvent $event) {echo 'eventfirst';}, 100);
        //In the class that call this event
        $manager->dispatch($this->getPersonEventClear($obj));
        $this->expectOutputString('eventfirstevent1event2event3');
    }

    public function testOneEventFromListenerInterfaceWithoutPriority(): void
    {
        $obj = new EntityOne();
        $obj->age = 30;
        $obj->name = 'john';
        //Events actions
        $manager = new EventManager();
        $manager->addListeners(new FakeListeners3());
        //In the class that call this event
        $manager->dispatch($this->getPersonEventClear($obj));
        $this->expectOutputString('Hello World !');
    }

    public function testMultipleEventsFromListenerInterfaceWithPriority(): void
    {
        $obj = new EntityOne();
        $obj->age = 30;
        $obj->name = 'John';
        //Events actions
        $manager = new EventManager();
        $manager->addListeners(new FakeListeners1());
        //In the class that call this event
        $manager->dispatch($this->getPersonEventClear($obj));
        $this->expectOutputString('Hello !Welcome !The end...');
    }

    public function testMultipleEventsFromListenerInterfaceWithoutPriority(): void
    {
        $obj = new EntityOne();
        $obj->age = 30;
        $obj->name = 'John';
        //Events actions
        $manager = new EventManager();
        $manager->addListeners(new FakeListeners2());
        //In the class that call this event
        $manager->dispatch($this->getPersonEventClear($obj));
        $this->expectOutputString('Hello John !The end...Welcome !');
    }

    public function testTwoEventsStopPropagation(): void
    {
        $obj = new EntityOne();
        $obj->age = 30;
        $obj->name = 'john';
        //Events actions
        $manager = new EventManager();
        $manager->addListener('person.event', static function (PersonEvent $event) {
            $event->getTarget()->setTest('hello ' . $event->getTarget()->getName());
        });
        $manager->addListener('person.event', static function (PersonEvent $event) {
            if ($event->getTarget()->getName() === 'john') {
                $event->stopPropagation();
            }
        });
        $manager->addListener('person.event', static function (PersonEvent $event) {
            $event->getTarget()->setAdult($event->getTarget()->getAge() > 17);
        });
        //In the class that call this event
        $manager->dispatch($this->getPersonEventClear($obj));
        self::assertEquals('hello john', $obj->getTest());
        self::assertFalse($obj->isAdult());
    }

    public function testMultipleEventsFromListenerInterfaceWithPriorityAndStopPropagation(): void
    {
        $obj = new EntityOne();
        $obj->age = 30;
        $obj->name = 'John';
        //Events actions
        $manager = new EventManager();
        $manager->addListeners(new FakeListeners1());
        $manager->addListeners(new FakeListeners4());
        $manager->addListeners(new FakeListeners5());
        //In the class that call this event
        $manager->dispatch($this->getPersonEventClear($obj));
        $this->expectOutputString('Hello !Welcome !The end... Other message and stop propagation...');
    }



}