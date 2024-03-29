<?php

namespace Noem\State;

use Noem\State\Transition\TransitionInterface;

interface StateMachineInterface
{

    /**
     * Implementing methods MUST request a TransitionInterface object from a TransitionProviderInterface.
     * If a transition object is returned, its target state MUST be transitioned to.
     *
     * @see TransitionInterface::target()
     *
     * @param object $payload
     * @return StateMachineInterface
     */
    public function trigger(object $payload): self;
}
