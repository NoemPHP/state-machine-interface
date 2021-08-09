<?php

namespace Noem\State;

interface CompoundStateInterface extends StateInterface
{

    /**
     * @return StateInterface[]
     */
    public function getChildren(): array;
}