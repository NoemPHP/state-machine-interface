<?php

namespace Noem\State;

interface HierarchicalStateInterface extends NestedStateInterface
{

    /**
     * Specify which of the sub-states - if any - is active once this state becomes active
     * @see NestedStateInterface::children()
     */
    public function initial(): ?StateInterface;
}
