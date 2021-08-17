<?php

namespace Noem\State\Observer;

use Noem\State\ObservableStateMachineInterface;
use Noem\State\StateInterface;

interface ActionObserver extends StateMachineObserver
{

    public function onAction(StateInterface $state, object $payload, ObservableStateMachineInterface $machine);
}
