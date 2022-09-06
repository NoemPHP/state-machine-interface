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
     * Replaces current context data with the specified array
     *
     * @param array $data
     *
     * @return void
     */
    public function replace(array $data): self;
}
