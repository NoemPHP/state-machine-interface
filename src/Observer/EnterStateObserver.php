<?php

namespace Noem\State\Observer;

use Noem\State\ObservableStateMachineInterface;
use Noem\State\StateInterface;

interface EnterStateObserver extends StateMachineObserver
{

    public function onEnterState(StateInterface $state, ObservableStateMachineInterface $machine);
}