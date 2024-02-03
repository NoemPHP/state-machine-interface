<?php

namespace Noem\State;

interface ContextInterface extends \ArrayAccess
{

    /**
     * Returns the trigger that enabled the transition to this state
     *
     * @return object
     */
    public function trigger(): object;

    /**
     * Wipe the context data
     * Whether to clear the state context on transitions is left for the application and/or
     * individual entry/exit callbacks to decide.
     *
     * @return mixed
     */
    public function clear(): self;

    /**
     * Reset the context data to its initial values
     * Whether to reset the state context on transitions is left for the application and/or
     * individual entry/exit callbacks to decide.
     *
     * @return mixed
     */
    public function reset(): self;

    /**
     * Replaces current context data with the specified array
     *
     * @param array $data
     *
     * @return void
     */
    public function replace(array $data): self;

    /**
     * Sets a new trigger object.
     * It is intended to be called during a transition to a new state, allowing context data to be retained
     * while setting a new trigger
     *
     * @param object $trigger
     *
     * @return $this
     */
    public function withTrigger(object $trigger): self;
}
