<?php

namespace Noem\State;

interface HierarchicalStateInterface extends NestedStateInterface
{

    /**
     * Specify which of the sub-states - if any - is active once this state becomes active
     * @see NestedStateInterface::children()
     */
    public function initial(): ?StateInterface;

    /**
     * @return StateInterface[] This state's sub-states
     */
    public function children(): array;
}
