<?php

namespace Fisrv\Models;

abstract class ResponseInterface extends FisrvObject
{
    public string $traceId;

    public string $apiTraceId;

    /**
     * Constructor
     *
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array|string|false $json = false)
    {
        FisrvObject::__construct($json, true);

        if (!isset($this->traceId) && isset($this->apiTraceId)) {
            $this->traceId = $this->apiTraceId;
        }
    }
}
