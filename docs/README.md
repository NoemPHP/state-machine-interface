# State Machine Interface
This repository contains contracts for building and consuming event-based finite state machines.

* TOC 
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

### StateMachineInterface

### TransitionProviderInterface
