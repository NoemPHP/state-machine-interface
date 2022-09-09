<?php

namespace Noem\State;

/**
 * Describes a superstate that mandates that ALL its children are active at the same time
 * @template T of StateMachineInterface
 *
 */
interface ParallelStateInterface extends NestedStateInterface
{

    /**
     * @return T[]
     */
    public function regions(): array;
}
