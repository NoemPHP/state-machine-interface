<?php

namespace Noem\State;

use Noem\State\StatefulActorInterface;
use Noem\State\Observer\ActionObserver;
use Noem\State\Observer\EnterStateObserver;
use Noem\State\Observer\ExitStateObserver;
use Noem\State\Observer\StateMachineObserver;

/**
 * The contract of a state machine implementation that is able to notify outside code of state changes.
 *
 * The machine's current state is an implicit observer. That means that a StateInterface MAY implement
 * one of the observer interfaces as well. When transitioning,
 * this MUST be checked and the state object needs to be notified as needed
 *
 */
interface ObservableStateMachineInterface extends StateMachineInterface
{

    /**
     * Adds an observer to the stack.
     * When a state machine exits a state, all ExitStateObservers MUST be notified.
     * When a new state is entered, all EnterStateObservers MUST be notified
     * When a state action is triggered (on implementors of StatefulActorInterface), all ActionObservers MUST
     * be notified
     *
     * @see EnterStateObserver
     * @see ExitStateObserver
     * @see ActionObserver
     * @see StatefulActorInterface
     *
     * @param StateMachineObserver $observer
     *
     * @return self
     */
    public function attach(StateMachineObserver $observer): ObservableStateMachineInterface;

    /**
     * Removes an observer from the stack.
     * The observer MUST no longer be notified of state changes
     *
     * @param StateMachineObserver $observer
     *
     * @return ObservableStateMachineInterface
     */
    public function detach(StateMachineObserver $observer): ObservableStateMachineInterface;
}