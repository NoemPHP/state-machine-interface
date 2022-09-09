<?php

namespace Noem\State;

/**
 * Describes a superstate that mandates that ALL its children are active at the same time
 *
 */
interface ParallelStateInterface extends NestedStateInterface
{
}
