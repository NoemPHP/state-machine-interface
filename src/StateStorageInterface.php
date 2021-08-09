<?php

namespace Noem\State;

interface StateStorageInterface
{

    /**
     * @return StateInterface
     */
    public function state(): StateInterface;

    public function save(StateInterface $stateConfiguration): void;
}