<?php

namespace Noem\State\Observer;

use Noem\State\ObservableStateMachineInterface;
use Noem\State\StateInterface;

interface ExitStateObserver extends StateMachineObserver
{

    public function onExitState(StateInterface $state, StateInterface $from, ObservableStateMachineInterface $machine);
}
