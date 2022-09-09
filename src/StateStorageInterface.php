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
     *
     * @param StateInterface|null $parent
     *
     * @return StateInterface
     * @throws \OutOfBoundsException
     */
    public function state(StateInterface $parent = null): StateInterface;

    /**
     * Write a new state to a storage backend
     */
    public function save(StateInterface $stateConfiguration, StateInterface $parent = null): void;
}
