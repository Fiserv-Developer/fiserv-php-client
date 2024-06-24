<?php

namespace Fisrv\Models;

abstract class ResponseInterface extends fisrvObject
{
    public string $traceId;

    /**
     * Constructor 
     * 
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array | string | false $json = false)
    {
        fisrvObject::__construct($json, true);
    }
}
