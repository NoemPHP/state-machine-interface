<?php

namespace Noem\State\Transition;

use Noem\State\StateInterface;

interface TransitionInterface
{

    public function source(): StateInterface;

    public function target(): StateInterface;

    public function isEnabled(object $trigger): bool;
}