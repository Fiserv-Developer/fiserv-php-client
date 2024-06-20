<?php

namespace Fiserv\Models;

abstract class ResponseInterface extends FiservObject
{
    public string $traceId;

    /**
     * Constructor 
     * 
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array | string | false $json = false)
    {
        FiservObject::__construct($json, true);
    }
}
