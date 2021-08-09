<?php

namespace Noem\State;

interface HierarchicalStateInterface extends NestedStateInterface
{

    public function initialSubState(): ?StateInterface;
}