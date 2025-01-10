<?php

namespace Fisrv\Models;

use Fisrv\Models\Traits\PaymentsResponseHead;

class CardLookupResponse extends ResponseInterface
{
    use PaymentsResponseHead;

    /** @var array<CardDetails> */
    public array $cardDetails;

    public string $requestStatus;
}
