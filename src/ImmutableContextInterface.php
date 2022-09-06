<?php

namespace Noem\State;

interface ImmutableContextInterface extends ContextInterface
{

    /**
     * Returns a new instance configured with a new trigger object.
     * It is intended to be called ruing a transition to a new state, allowing context data to be retained
     * while setting a new trigger
     *
     * @param object $trigger
     *
     * @return $this
     */
    public function withTrigger(object $trigger): self;
}
