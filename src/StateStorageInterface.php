<?php

namespace Noem\State;

/**
 * Provides an abstraction for bootstrapping a FSM instance with its initial state as well as
 * updating a new state after a successful transition.
 */
interface StateStorageInterface
{

    /**
     * Returns the current (stored) state
     * @return StateInterface
     */
    public function state(): StateInterface;

    /**
     * Write a new state to a storage backend
     */
    public function save(StateInterface $stateConfiguration): void;
}
