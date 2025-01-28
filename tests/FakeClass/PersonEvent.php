<?php

namespace MulerTech\EventManager\Tests\FakeClass;

use MulerTech\EventManager\Event;

class PersonEvent extends Event
{
    public function __construct(object $entity)
    {
        $this->setName('person.event');
        $this->setTarget($entity);
    }
}