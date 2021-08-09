<?php

namespace Noem\State;

interface StatefulActorInterface
{

    /**
     * Carry out an action corresponding to the given payload object
     *
     * @param object $payload Arbitrary data relevant for the desired action.
     *
     * @return object The payload object - modified by the implementing method if applicable
     */
    public function action(object $payload): object;
}