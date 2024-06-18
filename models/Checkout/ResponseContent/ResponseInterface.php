<?php

namespace Fiserv\Models;

abstract class ResponseInterface extends FiservObject
{
    public string $traceId;

    public function __construct($json = false)
    {
        FiservObject::__construct($json, true);
    }

    public function trace()
    {
    }
}
