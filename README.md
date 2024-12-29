# EventManager

___

The MulerTech EventManager package is a simple event manager that allows you to register and trigger events in your PHP application.

___

## Installation

1. Add to your "**composer.json**" file into require section:

```
"muler/event-manager": "^1.0"
```

and run the command:

```
php composer.phar update
```

2. Run the command:

```
php composer.phar require muler/event-manager "^1.0"
```

## Usage

<br>

###### Registering an event

```php
use Muler\EventManager\EventManager;

$eventManager = new EventManager();

$eventManager->addListener(new Listener());

// Into the class that calls the event
$eventManager->dispatch(new Event());
```

###### Creating a listener

```php
use Muler\EventManager\ListenerInterface;

class Listener implements ListenerInterface
{
    public function handle(Event $event)
    {
        // Do something
    }
}
```