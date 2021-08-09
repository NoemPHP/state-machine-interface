<?php

declare(strict_types=1);

namespace Noem\State;

interface StateMachineInterface
{

    /**
     * Implementing methods MUST receive a list of possible TransitionInterface objects
     * from a TransitionProviderInterface.
     * If a transition object is returned, its target state MUST be transitioned to.
     *
     * Note that there might be more than one transition returned. If the implementing class
     * is a deterministic state machine, that scenario would warrant an exception. TODO suggest exception
     *
     * @param object $payload
     * @return StateMachineInterface
     */
    public function trigger(object $payload): self;
}