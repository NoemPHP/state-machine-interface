<?php

namespace Noem\State;

interface ContextAwareStateMachineInterface extends StateMachineInterface
{

    /**
     * Returns the context related to the given state
     *
     * @param StateInterface $state
     *
     * @return ContextInterface
     */
    public function context(StateInterface $state): ContextInterface;
}
