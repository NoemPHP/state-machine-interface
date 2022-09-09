<?php

namespace Noem\State;

/**
 * Building block of a hierarchical FSM.
 * This interface describes a state that can be nested in a tree of arbitrary depth
 */
interface NestedStateInterface extends StateInterface
{

    /**
     * Return the superstate
     */
    public function parent(): ?StateInterface;

}
