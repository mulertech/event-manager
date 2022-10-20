<?php


namespace mtphp\EventManager\Tests\FakeClass;


use mtphp\EventManager\Event;

class PersonEvent extends Event
{

    public function __construct($entity)
    {
        $this->setName('person.event');
        $this->setTarget($entity);
    }



}