<?php

namespace Noem\State;

interface StateInterface extends \Stringable
{

    public function equals(StateInterface $otherState): bool;

    /**
     *  Event handlers might store metadata on the state object.
     *  When this object is called, any such data MUST be cleared
     * TODO: Think about replacing this with a getter for some StateContext class
     */
    //public function reset(): void;
}