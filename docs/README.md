# State Machine Interface
{: .no_toc }

This repository contains contracts for building and consuming event-based finite state machines.
## Table of contents
{: .no_toc .text-delta }
* [The pretty GH Pages version of this document shows a nice table of contents here](https://noemphp.github.io/state-machine-interface/) 
{:toc}
---


## Terminology

* **State** - A named representation of application state which can be determined either _explicitly_ through a direct transition, or _implictly_ through a chain of higher-order super-states.
* **Transition** - Defines when and how to move from one state to another
* **Trigger** - An event that would cause a transition. Any PHP `object` can be used as a trigger, making this interface highly interoperable with PSR-14 based event systems.
* **Action** - An action is again an `object` and works like an event. Its handlers are based on the current state though, enabling stateful behaviour in a very flexible manner. 
* **State Machine** - The main entrypoint for triggers and actions. Responsible for keeping track of the current state, performing transitions and notifying subscribers.
* **Transition Provider** - Returns a valid Transition object for any given _trigger_.
* **State Machine Observer** - Allows outside code to subscribe to state updates.
* **State Storage** - An abstraction layer to interface the process of loading & saving the active state with various sources (eg. memory, db, Redis)

## Concepts

### `StateMachineInterface`

The purpose of a class implementing this interface is to keep track of the active state as well as to delegate events from the outside application in case the extended `ObservableStateMachineInterface` is used . It's easy to be tempted to cram lots of logic and responsibility into this class, which is why the interfaces presented here deliberately keep some expected responsibility away from the class. 

```php:src/StateMachineInterface.php

```

### TransitionProviderInterface
