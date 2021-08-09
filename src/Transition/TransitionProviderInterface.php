<?php

namespace Noem\State\Transition;

use Noem\State\StateInterface;

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