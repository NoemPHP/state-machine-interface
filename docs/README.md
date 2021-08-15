# State Machine Interface
{: .no_toc }

This repository contains contracts for building and consuming event-based finite state machines.
## Table of contents
{: .no_toc .text-delta }
* [The pretty GH Pages version of this document shows a nice table of contents here](https://noemphp.github.io/state-machine-interface/)
{:toc}
* * *

## Terminology

* **State** - A named representation of application state which can be determined either *explicitly* through a direct transition, or *implictly* through a chain of higher-order super-states.
* **Transition** - Defines when and how to move from one state to another
* **Trigger** - An event that would cause a transition. Any PHP `object` can be used as a trigger, making this interface highly interoperable with PSR-14 based event systems.
* **Action** - An action is again an `object` and works like an event. Its handlers are based on the current state though, enabling stateful behaviour in a very flexible manner. 
* **State Machine** - The main entrypoint for triggers and actions. Responsible for keeping track of the current state, performing transitions and notifying subscribers.
* **Transition Provider** - Returns a valid Transition object for any given *trigger*.
* **State Machine Observer** - Allows outside code to subscribe to state updates.
* **State Storage** - An abstraction layer to interface the process of loading & saving the active state with various sources (eg. memory, db, Redis)

## Concepts

### [`StateMachineInterface`](https://github.com/NoemPHP/state-machine-interface/blob/master/src/StateMachineInterface.php)

```php:src/StateMachineInterface.php
<?php

declare(strict_types=1);

namespace Noem\State;

use Noem\State\Transition\TransitionInterface;

interface StateMachineInterface
{

    /**
     * Implementing methods MUST receive a TransitionInterface object from a TransitionProviderInterface.
     * If a transition object is returned, its target state MUST be transitioned to.
     * @see TransitionInterface::target()
     * @param object $payload
     * @return StateMachineInterface
     */
    public function trigger(object $payload): self;
}

```

The purpose of a class implementing this interface is to keep track of the active state as well as to delegate events from the outside application in case the extended `ObservableStateMachineInterface` is used . It's easy to be tempted to cram lots of logic and responsibility into this class, which is why the interfaces presented here deliberately keep some expected responsibility away from the class. 

#### Performing transitions

Consequently, the only required method on the base interface is a way to react to an external `trigger` (-> event). When the state machine is triggered, is **MUST** receive a valid `Transition` object from a `TransitionProvider`. 

#### Handling events

There are 2 additional interfaces related to event handling that a state machine can optionally implement:

**ObservableStateMachineInterface**

`php:src/ObservableStateMachineInterface.php `

**StatefulActorInterface**

`php:src/StatefulActorInterface.php `

### [`TransitionProviderInterface`](https://github.com/NoemPHP/state-machine-interface/blob/master/src/StateMachineInterface.php)

```php:src/Transition/TransitionProviderInterface.php
<?php

namespace Noem\State\Transition;

use Noem\State\StateInterface;

interface TransitionProviderInterface
{

    /**
     * Return a Transition object that matches the given state and trigger
     *
     * @param StateInterface $state For comparing the source state against
     * @param object $trigger For evaluating whether the transition is enabled
     *
     * @return TransitionInterface|null
     */
    public function getTransitionForTrigger(StateInterface $state, object $trigger): ?TransitionInterface;
}
```
The TransitionProvider is responsible for returning a valid transition based on the given action - and the current state. It is similar in intention and function to PSR-14's ListenerProvider:
* It reduces complexity of the state machine object by shielding it from knowledge about where states and transitions come from and how they interact
* Thus - in the best case - its responsibilities are reduced to
  - Keeping track of the current state
  - Dealing with events 
* Shifting transitions and interaction with the state graph outside of the machine enables interop between multiple packages: An `AggregateTransitionProvider` might gather the transitions from a number of modules, resulting in a state machine built from many loosely coupled fragments.
