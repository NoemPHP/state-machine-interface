<?php

namespace Noem\State\Transition;

use Noem\State\StateInterface;

interface TransitionInterface
{

    /**
     * The state to transition away from
     */
    public function source(): StateInterface;

    /**
     * The state to transition towards
     */
    public function target(): StateInterface;

    /**
     * Whether or not this transition CAN be taken.
     * If the transition is enabled by some event or has a guard function to check against,
     * this is where the check will happen
     */
    public function isEnabled(object $trigger): bool;
}
