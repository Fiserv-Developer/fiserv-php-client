<?php

namespace Fisrv\Models;

use Fisrv\Models\Traits\PaymentsResponseHead;

class HealthCheckResponse extends ResponseInterface
{
    use PaymentsResponseHead;

    public string $requestStatus;
}
