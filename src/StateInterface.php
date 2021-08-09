<?php

namespace Noem\State;

interface StateInterface extends \Stringable
{

    /**
     * Compare with another state instance. This method is used to prevent ambiguity between
     * string & instance comparisons It SHOULD be preferred over scalar string comparisons whenever possible
     */
    public function equals(StateInterface $otherState): bool;

    /**
     *  Event handlers might store metadata on the state object.
     *  When this object is called, any such data MUST be cleared
     * TODO: Think about replacing this with a getter for some StateContext class
     */
    //public function reset(): void;
}