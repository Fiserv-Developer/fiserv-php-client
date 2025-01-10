<?php

namespace Fisrv\Models\Traits;

use Fisrv\Models\Error;

trait PaymentsResponseHead
{
    public string $type;

    public string $apiTraceId;

    public string $clientRequestId;

    public Error $error;

    public string $responseType;
}
