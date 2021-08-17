<?php

namespace Noem\State;

interface StateInterface extends \Stringable
{

    /**
     * Compare with another state instance. This method is used to prevent ambiguity when doing
     * string & instance comparisons independently.
     * It SHOULD be preferred over scalar string comparisons whenever possible
     */
    public function equals(string|self $otherState): bool;
}
