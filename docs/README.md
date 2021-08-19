<!-- @formatter:off -->
# State Machine Interface
{: .no_toc } 
This repository contains contracts for building and consuming event-based finite state machines.
## Table of contents
{: .no_toc .text-delta }
1. [The pretty GH Pages version of this document shows a nice table of contents here](https://noemphp.github.io/state-machine-interface/)

{:toc}

---
<!-- @formatter:on -->

## 1 - Terminology

* **State** - A named representation of application state which can be determined either *explicitly* through a direct
  transition, or *implictly* through a chain of higher-order super-states.
* **Transition** - Defines when and how to move from one state to another
* **Trigger** - An event that would cause a transition. Any PHP `object` can be used as a trigger, making this interface
  highly interoperable with PSR-14 based event systems.
* **Action** - An action is again an `object` and works like an event. Its handlers are based on the current state
  though, enabling stateful behaviour in a very flexible manner.
* **State Machine** - The main entrypoint for triggers and actions. Responsible for keeping track of the current state,
  performing transitions and notifying subscribers.
* **Transition Provider** - Returns a valid Transition object for any given *trigger*.
* **State Machine Observer** - Allows outside code to subscribe to state updates.
* **State Storage** - An abstraction layer to interface the process of loading & saving the active state with various
  sources (eg. memory, db, Redis)

## 2 - Concepts

### 2.1 - [`StateMachineInterface`](https://github.com/NoemPHP/state-machine-interface/blob/master/src/StateMachineInterface.php)

The purpose of a class implementing this interface is to keep track of the active state as well as to delegate events
from the outside application in case the extended `ObservableStateMachineInterface` is used . It's easy to be tempted to
cram lots of logic and responsibility into this class, which is why the interfaces presented here deliberately keep some
expected responsibility away from the class.

[embed]:# "path: ../src/StateMachineInterface.php, match: 'interface.*}'"

```php
interface StateMachineInterface
{

    /**
     * Implementing methods MUST receive a TransitionInterface object from a TransitionProviderInterface.
     * If a transition object is returned, its target state MUST be transitioned to.
     *
     * @see TransitionInterface::target()
     *
     * @param object $payload
     * @return StateMachineInterface
     */
    public function trigger(object $payload): self;
}
```

#### 2.1.1 - Performing transitions

Consequently, the only required method on the base interface is a way to react to an external `trigger` (-> event). When
the state machine is triggered, is **MUST** receive a valid `Transition` object from a `TransitionProvider`.

A state machine MAY receive a `StateStorageInterface` as an injected depency. If this is
used, `StateStorageInterface::save()` MUST be called with the new state so that it can be saved externally.

An `ObservableStateMachineInterface` MUST notify all of its subscribers when a transition is made. More about this in
the next section.

#### 2.1.2 - Handling events

There are 2 additional interfaces related to event handling that a state machine can optionally implement:

**ObservableStateMachineInterface**

This interface defines an Observer pattern segregated into 3 areas of interest:

* Entering a state
* Exiting a state
* Performing an action

[embed]:# "path: ../src/ObservableStateMachineInterface.php, match: 'interface\s.*}'"

```php
interface ObservableStateMachineInterface extends StateMachineInterface
{

    /**
     * Adds an observer to the stack.
     * When a state machine exits a state, all ExitStateObservers MUST be notified.
     * When a new state is entered, all EnterStateObservers MUST be notified
     * When a state action is triggered (on implementors of StatefulActorInterface),
     * all ActionObservers MUST be notified
     *
     * @see Observer\EnterStateObserver, Observer\ExitStateObserver, Observer\ActionObserver, ActorInterface
     *
     * @param Observer\StateMachineObserver $observer
     *
     * @return self
     */
    public function attach(Observer\StateMachineObserver $observer): self;

    /**
     * Removes an observer from the stack.
     * The observer MUST no longer be notified of state changes
     *
     * @param Observer\StateMachineObserver $observer
     *
     * @return self
     */
    public function detach(Observer\StateMachineObserver $observer): self;
}
```

State machines can therefore be written without being aware of any event-handling logic, let along providing their own.
Use-cases for `StateMachineObserver`s include:

* Proving internal stateful behaviour defined as a state's `onEntry`, `onExit` or `action` callbacks
* Logging
* Bridging to external event systems

**ActorInterface**

Classes implementing this interface provide a way to process to arbitrary `object` payloads via an `action($payload)`
method.

[embed]:# "path: ../src/ActorInterface.php, match: 'interface.*}'"

```php
interface ActorInterface
{

    /**
     * Carry out an action corresponding to the given payload object
     *
     * @param object $payload Arbitrary data relevant for the desired action.
     *
     * @return object The payload object - modified by the implementing method if applicable
     */
    public function action(object $payload): object;
}
```

This is the primary way to interface the application logic with the state machine. Whenever state-dependent behaviour or
data is required, a corresponding action can be requested from the state machine.

It is meant to serve as a generic and flexible entrypoint for any use case, so it is a good idea to wrap this method
with more explicit sugar methods to directly address the usage scenarios of your specific state machine.

```php
namespace Noem\State;

class MyFSM implements StateMachineInterface, ActorInterface {

    public function trigger(object $payload): self {
        // ... implementation
        return $this;
    }
    
    public function action(object $payload): object {
        // ... implementation
    }
    
    public function buttonLabel(): string {
        $result = $this->action((object)['label' => '']);
        return (string) $result->label;
    }

}
```

* * *

### 2.2 - [`TransitionProviderInterface`](https://github.com/NoemPHP/state-machine-interface/blob/master/src/StateMachineInterface.php)

The TransitionProvider is responsible for returning a valid transition based on the given action and the current state.

[embed]:# "path: ../src/Transition/TransitionProviderInterface.php, match: 'interface.*}'"

```php
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

It is similar in intention and function to PSR-14's ListenerProvider:

* It reduces complexity of the state machine object by shielding it from knowledge about where states and transitions
  come from and how they interact
* Thus, its responsibilities CAN be reduced to
    - Keeping track of the current state
    - Dealing with events
* Shifting transitions and interaction with the state graph outside the machine enables interop between multiple
  packages: An `AggregateTransitionProvider` might gather the transitions from a number of modules, resulting in a state
  machine built from many loosely coupled fragments.
