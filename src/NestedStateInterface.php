<?php

namespace Noem\State;

interface NestedStateInterface extends StateInterface
{

    public function parent(): ?StateInterface;

    /**
     * @return StateInterface[]
     */
    public function children(): array;
}