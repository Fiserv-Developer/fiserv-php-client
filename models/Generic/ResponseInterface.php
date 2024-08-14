<?php

namespace Fisrv\Models;

abstract class ResponseInterface extends FisrvObject
{
    public string $traceId;

    public int $httpCode;

    /**
     * Constructor
     *
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array|string|false $json = false)
    {
        FisrvObject::__construct($json, true);

        $this->moveProperty($this, 'apiTraceId', 'traceId');
    }
}
